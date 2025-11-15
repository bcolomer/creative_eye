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

            {{-- Grid de Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @foreach ($productos as $producto)

                    {{-- 1. La tarjeta AHORA es un enlace (<a>) --}}
                    {{-- (La ruta 'productos.edit' aún no existe, la crearemos después)--}}
                {{--     <div>eliminar este div si lo dejo como enlace a --}}
                    <a href="{{ route('productos.edit', $producto->producto_id) }}"
                       class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg
                              hover:shadow-lg transition-shadow duration-200">

                        {{-- 2. Solo la Imagen --}}
                        <img src="{{ $producto->foto }}" alt="{{ $producto->nombre }}" class="w-full h-48 object-cover">

                        {{-- 3. Solo el Nombre (centrado) --}}
                        <div class="p-4 text-center">
                            <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 truncate">
                                {{ $producto->nombre }}
                            </h3>
                        </div>
                    </a> {{-- </div> eliminar este div si lo dejo como enlace  --}}
                    {{-- Fin de la Card/Enlace --}}

                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>
