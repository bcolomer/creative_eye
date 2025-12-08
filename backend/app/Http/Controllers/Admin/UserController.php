<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = User::with('rol'); 

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%')
                    ->orWhere('nombre_usuario', 'like', '%' . $search . '%')
                    ->orWhereHas('rol', function ($r) use ($search) {
                        $r->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }

        $users = $query->paginate(5)->appends(['search' => $search]);

        return view('admin.usuarios.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.usuarios.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|email|max:255|unique:usuarios,nombre_usuario',
            'password' => 'nullable|string|min:8|confirmed',
            'rol_id' => 'required|exists:roles,rol_id',
            'foto' => 'nullable|image|max:2048',
        ]);

        $password = $validated['password']
            ? Hash::make($validated['password'])
            : Hash::make('12345678');

        $rutaFoto = '/images/creativelogo.png'; // Default

        if ($request->hasFile('foto')) {
            // Guardamos en disco 'profile_photos'
            $path = $request->file('foto')->store('profile_photos');
            // Guardamos SOLO el nombre del archivo en la BD para evitar problemas de rutas dobles
            $rutaFoto = basename($path);
        }

        $user = User::create([
            'nombre' => $validated['nombre'],
            'nombre_usuario' => $validated['nombre_usuario'],
            'password' => $password,
            'rol_id' => $validated['rol_id'],
            'foto' => $rutaFoto,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('status', __('usuario.create_success_msg', ['nombre' => $user->nombre]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.usuarios.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'rol_id' => 'required|exists:roles,rol_id',
        ]);

        $user->update([
            'nombre' => $validated['nombre'],
            'rol_id' => $validated['rol_id'],
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('status', __('usuario.update_success_msg', ['nombre' => $user->nombre]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Borrar foto si existe y no es la default
        if ($user->foto && !str_contains($user->foto, 'creativelogo')) {
             // Intentamos borrar tanto con prefijo como sin él
             $path = 'profile_photos/' . basename($user->foto);
             if (Storage::exists($path)) {
                 Storage::delete($path);
             }
        }

        $user->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('status', __('usuario.delete_success_msg', ['nombre' => $user->nombre]));
    }
}
