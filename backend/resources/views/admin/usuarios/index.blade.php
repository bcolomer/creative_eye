<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('usuario.index_title') }}
        </h2>
    </x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
{{-- INICIO BUSCADOR Y BOTÓN CREAR --}}
<div class="flex justify-between items-center mb-4 gap-2 pr-4">

    {{-- Formulario de Búsqueda --}}
    <form method="GET" action="{{ route('admin.usuarios.index') }}" class="flex items-center w-full max-w-sm">
        <x-text-input type="text" name="search"
            :placeholder="__('usuario.search_placeholder_user')"
            class="w-full mr-2" value="{{ request('search') }}" />
        <x-primary-button type="submit">
            {{ __('usuario.button_search') }}
        </x-primary-button>
    </form>

    {{-- Botón de Creación --}}
    <a href="{{ route('admin.usuarios.create') }}">
        <x-primary-button class="flex items-center justify-center h-10">
            {{-- Versión MÓVIL: Icono (Usuario +) --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 md:hidden">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>

            {{-- Versión PC: Texto completo --}}
            <span class="hidden md:block">
                {{ __('usuario.button_create_new') }}
            </span>
        </x-primary-button>
    </a>
</div>
{{-- FIN BUSCADOR Y BOTÓN CREAR --}}
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 p-3 bg-green-100 dark:bg-green-700 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('usuario.col_id') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('usuario.col_photo') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('usuario.col_name') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('usuario.col_email') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('usuario.col_role') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('usuario.col_actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->usuario_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($user->foto)
                                            <img src="{{ route('profile.photo', ['fileName' => $user->foto]) }}" class="h-14 w-14 rounded-m-2 object-cover" alt="{{ $user->nombre }}"
                                                 onerror="this.onerror=null; this.src='/images/creativelogo.png';">
                                        @else
                                            <span class="text-gray-400">{{ __('usuario.no_photo') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $user->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->nombre_usuario }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $user->rol_id == 1 ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $user->rol_id == 2 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $user->rol_id == 3 ? 'bg-green-100 text-green-800' : '' }}">
                                            {{ $user->rol->nombre ?? __('usuario.no_role') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.usuarios.edit', $user->usuario_id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('usuario.button_edit') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-lg text-gray-500 dark:text-gray-400">
                                        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            {{ __('usuario.no_search_results_title') }}
                                        </h3>
                                        <p>
                                            {{ __('usuario.no_search_results_info') }}
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        </table>
                    </div>

                    {{-- paginacion --}}
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
