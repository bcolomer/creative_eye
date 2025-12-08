
<x-app-layout>
    {{-- Cabecera (Header) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('producto.index_title') }}
        </h2>
    </x-slot>

    {{-- Contenido Principal --}}


    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-4">

            {{-- Formulario de Búsqueda --}}

           <form method="GET" action="{{ route('productos.index') }}" class="flex items-center w-full max-w-lg">
                <x-text-input type="text" name="search" placeholder="{{__('producto.search_placeholder')  }}" class="w-full mr-2" value="{{ request('search') }}" />
                <x-primary-button type="submit">
                   {{ __('producto.button_search')}}
                </x-primary-button>
            </form>

            {{-- Botón de Creación --}}
            <a href="{{ route('productos.create') }}">
                <x-primary-button>
                   {{ __('producto.button_create_new') }}
                </x-primary-button>
            </a>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 p-3 bg-green-100 dark:bg-green-700 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"></div>

            {{-- Grid de Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @forelse ($productos as $producto)
                <a href="{{ route('productos.edit', $producto->producto_id) }}"
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg
                    hover:shadow-lg transition-shadow duration-200">
                    {{--  la Imagen --}}
                    <img src="{{ $producto->foto }}" alt="{{ $producto->nombre }}" class="w-full h-48 object-cover" onerror="this.onerror=null; this.src='/images/creativelogo.png';">
                    {{-- el Nombre --}}
                    <div class="p-4 text-center">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 truncate">
                            {{ $producto->nombre }}
                        </h3>
                    </div>
                </a>
                @empty
                    {{-- MENSAJE DE NO RESULTADOS --}}
                    <div class="md:col-span-4 text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('producto.no_results_title') }}
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            {{ __('producto.no_results_info') }}
                        </p>
                    </div>
                @endforelse

            </div>
             {{-- paginacion --}}
                    <div class="mt-4">
                        {{ $productos->links() }}
                    </div>
        </div>
    </div>
</x-app-layout>
