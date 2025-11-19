<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gestión de Usuarios (Rol: Administrador)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.usuarios.create') }}">
                    <x-primary-button>
                        {{ __('Crear Nuevo Usuario') }}
                    </x-primary-button>
                </a>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Foto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Usuario (Email)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rol</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->usuario_id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{-- Usamos tu 'getFotoAttribute' si también lo pusiste en User, o la lógica directa --}}
                                            @if($user->foto)
                                                <img src="{{ $user->foto }}" class="h-14 w-14 rounded-m-2 object-cover">
                                            @else
                                                <span class="text-gray-400">Sin foto</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $user->nombre }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->nombre_usuario }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{-- Aquí mostramos el nombre del rol gracias a la relación 'rol' --}}
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $user->rol_id == 1 ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $user->rol_id == 2 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $user->rol_id == 3 ? 'bg-green-100 text-green-800' : '' }}">
                                                {{ $user->rol->nombre ?? 'Sin Rol' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{-- Aquí pondremos los botones de Editar/Borrar --}}
                                            <a href="{{ route('admin.usuarios.edit', $user->usuario_id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                        </td>
                                    </tr>
                                @endforeach
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
