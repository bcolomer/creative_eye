<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('usuario.create_title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Formulario para crear un nuevo usuario --}}
                    <form method="POST" action="{{ route('admin.usuarios.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Mensaje de Éxito y Errores --}}
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ session('status') }}
                            </div>
                        @endif
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
                                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                            </div>

                            {{-- CAMPO EMAIL / NOMBRE DE USUARIO --}}
                            <div>
                                <x-input-label for="nombre_usuario" :value="__('usuario.field_email')" />
                                <x-text-input id="nombre_usuario" name="nombre_usuario" type="email" class="mt-1 block w-full" :value="old('nombre_usuario')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nombre_usuario')" />
                            </div>

                            {{-- CAMPO ROL (Dropdown) --}}
                            <div class="md:col-span-2">
                                <x-input-label for="rol_id" :value="__('usuario.field_role')" />
                                <select id="rol_id" name="rol_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    <option value="">{{ __('usuario.select_role') }}</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->rol_id }}" {{ old('rol_id') == $rol->rol_id ? 'selected' : '' }}>
                                            {{ $rol->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('rol_id')" />
                            </div>

                            {{-- CAMPO PASSWORD (Opcional: Si se deja vacío, usa 12345678) --}}
                            <div>
                                <x-input-label for="password" :value="__('usuario.field_password_optional')" />
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('admin.password_optional_info') }}</p>
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>

                            {{-- CAMPO PASSWORD CONFIRMATION (para la regla 'confirmed') --}}
                            <div>
                                <x-input-label for="password_confirmation" :value="__('usuario.field_password_confirm')" />
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1" style="visibility: hidden;">_</p>
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                            </div>

                            {{-- CAMPO FOTO (Opcional, es un file upload para el admin)
                            <div class="md:col-span-2">
                                <x-input-label for="foto" :value="__('usuario.field_photo')" />
                                <x-text-input id="foto" name="foto" type="file" class="mt-1 block w-full" :value="old('foto')" placeholder="{{  __('usuario.field_photo_placeholder')}}" />
                                <x-input-error class="mt-2" :messages="$errors->get('foto')" />
                            </div>--}}
                        </div>

                        {{-- BOTÓN DE GUARDAR --}}
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('usuario.button_create') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
