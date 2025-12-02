<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    { // Guarda la ruta de la foto ANTIGUA
        $oldPhotoPath = $request->user()->foto;

        // Rellena datos validados
        $request->user()->fill($request->validated());

        // Comprobar si se ha subido una FOTO NUEVA
        if ($request->hasFile('foto')) {

            Log::debug('--- INICIO DEBUG FOTO DE PERFIL ---');

            Log::debug('Ruta Antigua (leída de la BBDD): ' . $oldPhotoPath);

            // Guarda la foto NUEVA
            $path = $request->file('foto')->store('', 'profile_private');
            $request->user()->foto = $path;
            Log::debug('Ruta Nueva (guardada en BBDD): ' . $request->user()->foto);


            // BORRA LA FOTO ANTIGUA
            if ($oldPhotoPath && str_starts_with($oldPhotoPath, '/storage/')) {
                $storagePath = str_replace('/storage/', '', $oldPhotoPath);

                Log::debug('Intentando borrar archivo: ' . $storagePath);

                Storage::disk('public')->delete($storagePath);
            } else {
                Log::debug('No se intentó borrar. La ruta antigua no era válida (no empezaba con /storage/).');
            }
            Log::debug('--- FIN DEBUG FOTO DE PERFIL ---');
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', __('profile.profile_updated'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Si borra el perfil que se borre su foto
        if ($user->foto) {
            Storage::disk('profile_private')->delete($user->foto);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'account-deleted');
    }

    /**
     * Muestra la foto de perfil de un usuario, verificando la autorización.
     */
    public function showPhoto(string $fileName)
    {
        // Obtenemos el usuario que está intentando acceder a la foto
        $user = Auth::user();

        // Buscamos al usuario que posee este archivo (fileName es la ruta almacenada)
        $photoOwner = \App\Models\User::where('foto', $fileName)->first();

        // Si el archivo no corresponde a ningún usuario (o no existe)
        if (!$photoOwner) {
            return response()->json(['message' => __('api.photo_not_found')], 404);
        }

        // Comprobación de Autorización: Solo el dueño O el administrador pueden verla
        $isAdmin = $user->rol_id == 1;
        $isOwner = $user->usuario_id === $photoOwner->usuario_id;

        // Si NO es Admin Y NO es el Dueño, acceso denegado.
        if (!$isAdmin && !$isOwner) {
            return response()->json(['message' => __('api.photo_access_denied')], 403);
        }

        // Transmitir el archivo desde el disco privado
        return Storage::disk('profile_private')->response($fileName);
    }
}
