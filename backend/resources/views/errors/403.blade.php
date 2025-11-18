<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Acceso Restringido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-2xl font-bold text-red-500 mb-4">
                        ❌ ERROR 403: ACCESO DENEGADO ❌
                    </h3>

                    <p class="text-lg">
                        No tienes los permisos necesarios para acceder a esta sección.
                        (Tu rol no permite el acceso a este área, si crees que es un error comunicate con el responsable técnico).
                    </p>

                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                   <div>
                    <p class="mb-3">¿Quieres volver a la página principal o cerrar sesión?</p>
                   </div>

                   <a href="/" class="mr-4">
                        <x-primary-button type="button">
                            {{ __('Volver a la Página Principal') }}
                        </x-primary-button>
                   </a>

                        {{-- Formulario de Logout  --}}
                        <form method="POST" action="{{ route('logout') }}" class="inline-block">
                            @csrf
                            <x-danger-button type="submit">
                                {{ __('Cerrar Sesión') }}
                            </x-danger-button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
