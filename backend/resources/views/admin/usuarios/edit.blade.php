@php
    /** @var \App\Models\User $user */
    /** @var \App\Models\Role[] $roles */
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('usuario.edit_title_prefix') }} {{ $user->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- AVISO DE ÉXITO --}}
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- FORMULARIO DE EDICIÓN --}}
                    <form method="POST" action="{{ route('admin.usuarios.update', $user->usuario_id) }}">
                        @csrf
                        @method('PUT') {{-- Método para actualizar --}}

                        {{-- Mensajes de Error (si los hay) --}}
                        @if ($errors->any())
                            <div class="mb-4 font-medium text-red-600 dark:text-red-400">
                            {{ __('admin.validation_errors', ['count' => $errors->count()]) }}
                            </div>
                        @endif

                        {{-- Grid de Campos --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- CAMPO NOMBRE --}}
                            <div>
                                <x-input-label for="nombre" :value="__('usuario.field_name')" />
                                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $user->nombre)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                            </div>

                            {{-- CAMPO EMAIL / NOMBRE DE USUARIO (READONLY) --}}
                            <div>
                                <x-input-label for="nombre_usuario" :value="__('usuario.field_email')" />
                                <x-text-input id="nombre_usuario" name="nombre_usuario" type="email" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700" :value="$user->nombre_usuario" readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('nombre_usuario')" />
                            </div>

                            {{-- CAMPO ROL (Dropdown) --}}
                            <div class="md:col-span-2">
                                <x-input-label for="rol_id" :value="__('usuario.field_role')" />
                                <select id="rol_id" name="rol_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    <option value="">{{ __('usuario.select_role') }}</option>
                                    {{-- El controlador le pasa la variable $roles con todos los roles --}}
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->rol_id }}" {{ old('rol_id', $user->rol_id) == $rol->rol_id ? 'selected' : '' }}>
                                            {{ $rol->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('rol_id')" />
                            </div>
                        </div>

                        {{-- BOTÓN DE GUARDAR --}}
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('usuario.button_update') }}
                            </x-primary-button>
                        </div>
                    </form>

                    {{-- Formulario de Borrado de Cuenta  --}}
                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('usuario.advanced_options_title') }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            {{ __('admin.delete_account_info') }}
                        </p>

                        <form method="POST" action="{{ route('admin.usuarios.destroy', $user->usuario_id) }}" onsubmit="return confirm({{ __('admin.confirm_delete_user', ['nombre' => $user->nombre]) }});">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit">
                                {{ __('usuario.button_delete_account') }}
                            </x-danger-button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
