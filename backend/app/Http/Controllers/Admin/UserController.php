<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        // Usamos 'with' para cargar también el nombre del ROL de cada usuario de forma eficiente
        $users = User::with('rol')->paginate(5);

        //  Devolvemos la vista (que crearemos después)
        return view('admin.usuarios.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //  lista de roles para que el administrador pueda seleccionar uno.
        $roles = \App\Models\Role::all();

        return view('admin.usuarios.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  Validación: Aseguramos que el email sea único y la contraseña sea segura.
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|email|max:255|unique:usuarios,nombre_usuario',
            'password' => 'nullable|string|min:8|confirmed', // 'confirmed' busca 'password_confirmation'
            'rol_id' => 'required|exists:roles,rol_id',
            'foto' => 'nullable|string',
        ]);
        //  Asignar la contraseña
        // Si el admin proporcionó una contraseña, la usamos.
        // Si no (está nula), usamos la contraseña por defecto '12345678'.
        $password = $validated['password']
            ? \Illuminate\Support\Facades\Hash::make($validated['password'])
            : \Illuminate\Support\Facades\Hash::make('12345678');

        // Creación del usuario
        $user = User::create([
            'nombre' => $validated['nombre'],
            'nombre_usuario' => $validated['nombre_usuario'],
            'password' => $password,
            'rol_id' => $validated['rol_id'],
            'foto' => $validated['foto'] ?? '/images/creativelogo.png', // Fallback si no hay foto
        ]);

        return redirect()->route('admin.usuarios.index')->with('status', '¡Usuario ' . $user->nombre . ' creado con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *  @param \App\Models\User $user
     *
     */
    public function edit(User $user)
    {
        // paso la lista de roles para que el administrador pueda cambiarlo.
        $roles = \App\Models\Role::all();

        return view('admin.usuarios.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     */
    public function update(Request $request, User $user)
    {
        // Validar los datos. El Administrador solo puede cambiar el nombre y el rol.
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'rol_id' => 'required|exists:roles,rol_id',
        ]);

        // Actualizar el usuario en la base de datos
        $user->update([
            'nombre' => $validated['nombre'],
            'rol_id' => $validated['rol_id'],
        ]);

        return redirect()->route('admin.usuarios.index')->with('status', '¡Usuario ' . $user->nombre . ' actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Models\User $user
     */
    public function destroy(User $user)
    {
        //  Borrar la foto de perfil del disco
        if ($user->foto && str_starts_with($user->foto, '/storage/')) {
            $storagePath = str_replace('/storage/', '', $user->foto);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($storagePath);
        }

        // 2. Borrar el usuario de la base de datos
        $user->delete();

        return redirect()->route('admin.usuarios.index')->with('status', '¡Usuario ' . $user->nombre . ' eliminado con éxito!');
    }
}
