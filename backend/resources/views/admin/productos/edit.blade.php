<x-app-layout>
    {{-- Cabecera (Header) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Producto: {{ $producto->nombre }}
        </h2>
    </x-slot>

    {{-- Contenido Principal --}}
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

                    <form method="POST" action="{{ route('productos.update', $producto->producto_id) }}" enctype="multipart/form-data">
                        @csrf       {{-- Token de seguridad de laravel--}}
                        @method('PUT')

                        {{-- CAMPO NOMBRE --}}
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre')" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $producto->nombre)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        {{-- CAMPO DESCRIPCIÓN --}}
                        <div class="mt-4">
                            <x-input-label for="descripcion" :value="__('Descripción')" />
                            <textarea id="descripcion" name="descripcion" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('descripcion', $producto->descripcion) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                        </div>

                        {{-- Grid para Precio, Stock y Código --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">

                            {{-- CAMPO PRECIO --}}
                            <div>
                                <x-input-label for="precio" :value="__('Precio')" />
                                <x-text-input id="precio" name="precio" type="number" step="0.01" class="mt-1 block w-full" :value="old('precio', $producto->precio)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('precio')" />
                            </div>

                            {{-- CAMPO CANTIDAD (Stock) --}}
                            <div>
                                <x-input-label for="cantidad" :value="__('Stock (Cantidad)')" />
                                <x-text-input id="cantidad" name="cantidad" type="number" class="mt-1 block w-full" :value="old('cantidad', $producto->cantidad)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('cantidad')" />
                            </div>

                            {{-- CAMPO CÓDIGO --}}
                            <div>
                                <x-input-label for="codigo" :value="__('Código')" />
                                <x-text-input id="codigo" name="codigo" type="text" class="mt-1 block w-full" :value="old('codigo', $producto->codigo)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('codigo')" />
                            </div>
                        </div>

                        {{-- CAMPO FOTO --}}
                        <div class="mt-4">
                            <x-input-label for="foto" :value="__('Foto de Producto (Opcional: Subir una nueva)')" />
                            <img class="h-32 w-32 rounded-md object-cover my-2" src="{{ $producto->foto }}" alt="{{ $producto->nombre }}">
                            <x-text-input id="foto" name="foto" type="file" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
                        </div>


                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Guardar Cambios') }}
                            </x-primary-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
