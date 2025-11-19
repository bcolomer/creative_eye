{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
</head>
<body>
    <h1>Panel de Administración - Lista de Productos</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Codigo</th>
                <th>Imagen</th>
                <th>Descripcion</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->producto_id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->precio }}</td>
                    <td>{{ $producto->cantidad }}</td>
                    <td>{{ $producto->codigo }}</td>
                    <td><img src="{{ $producto->foto }}" alt=""></td>
                    <td>{{ $producto->descripcion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> --}}


<x-app-layout>
    {{-- Cabecera (Header) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gestión de Productos (Almacén)
        </h2>
    </x-slot>

    {{-- Contenido Principal --}}


    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-4">

            {{-- Formulario de Búsqueda --}}
            {{-- <form method="GET" action="{{ route('productos.index') }}" class="flex items-center w-full max-w-sm">
                <x-text-input type="text" name="search" placeholder="Buscar por nombre, código o precio..." class="w-full mr-2" value="{{ request('search') }}" />
                <x-primary-button type="submit">
                    {{ __('Buscar') }}
                </x-primary-button>
            </form> --}}

            {{-- Botón de Creación --}}
            <a href="{{ route('productos.create') }}">
                <x-primary-button>
                    {{ __('Crear Nuevo Producto') }}
                </x-primary-button>
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"></div>

            {{-- Grid de Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @foreach ($productos as $producto)
                <a href="{{ route('productos.edit', $producto->producto_id) }}"
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg
                hover:shadow-lg transition-shadow duration-200">
                        {{--  la Imagen --}}
                        <img src="{{ $producto->foto }}" alt="{{ $producto->nombre }}" class="w-full h-48 object-cover">
                        {{-- el Nombre --}}
                        <div class="p-4 text-center">
                            <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 truncate">
                                {{ $producto->nombre }}
                            </h3>
                        </div>
                    </a>

                @endforeach

            </div>
             {{-- paginacion --}}
                    <div class="mt-4">
                        {{ $productos->links() }}
                    </div>
        </div>
    </div>
</x-app-layout>
