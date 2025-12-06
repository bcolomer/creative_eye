<x-app-layout>
    {{-- Cabecera (Header) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('producto.create_title') }}
        </h2>
    </x-slot>

    {{-- Contenido Principal --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- FORMULARIO DE CREACIÓN --}}
                    <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
                        @csrf       {{-- Token de seguridad --}}

                        {{-- CAMPO NOMBRE --}}
                        <div>
                            <x-input-label for="nombre" :value="__('producto.field_name')" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        {{-- CAMPO DESCRIPCIÓN --}}
                        <div class="mt-4">
                            <x-input-label for="descripcion" :value="__('producto.field_description')" />
                            <textarea id="descripcion" name="descripcion" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('descripcion') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                        </div>

                        {{-- CAMPO CATEGORIA --}}
                        <div class="mb-4">
                            <label for="categoria_id" class="block text-gray-700 font-bold mb-2">{{  __('producto.category')}}</label>
                            <select name="categoria_id" id="categoria_id" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-brand-teal">

                                <option value="">{{  __('producto.choose-category')}}</option>

                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->categoria_id }}" {{ old('categoria_id') == $categoria->categoria_id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach

                            </select>

                            @error('categoria_id')
                                <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Grid para Precio, Stock y Código --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">

                            {{-- CAMPO PRECIO --}}
                            <div>
                                <x-input-label for="precio" :value="__('producto.field_price')" />
                                <x-text-input id="precio" name="precio" type="number" step="0.01" class="mt-1 block w-full" :value="old('precio')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('precio')" />
                            </div>

                            {{-- CAMPO CANTIDAD (Stock) --}}
                            <div>
                                <x-input-label for="cantidad" :value="__('producto.field_stock')" />
                                <x-text-input id="cantidad" name="cantidad" type="number" class="mt-1 block w-full" :value="old('cantidad')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('cantidad')" />
                            </div>

                            {{-- CAMPO CÓDIGO --}}
                            <div>
                                <x-input-label for="codigo" :value="__('producto.field_code')" />
                                <x-text-input id="codigo" name="codigo" type="text" class="mt-1 block w-full" :value="old('codigo')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('codigo')" />
                            </div>
                        </div>

                        {{-- CAMPO FOTO --}}
                        <div class="mt-4">
                            <x-input-label for="foto" :value="__('producto.field_photo')" />
                            {{-- (Aquí no mostramos foto antigua porque es un producto nuevo) --}}
                            <x-text-input id="foto" name="foto" type="file" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
                        </div>


                        {{-- BOTÓN DE GUARDAR --}}
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                               {{ __('producto.button_create') }}
                            </x-primary-button>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
