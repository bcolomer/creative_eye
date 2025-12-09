<nav x-data="{ open: false }" class="bg-[#00747C] border-b border-[#00BBC9]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 md:h-24">
            <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ asset('images/creativelogo.png') }}" alt="Creative Eye" class="block h-16 md:h-24 w-auto">
                        </a>
                    </div>

            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-[#CACACA]">
                        {{ __('messages.dashboard') }}
                    </x-nav-link>

                    {{-- Opcional: Enlace a la Tienda --}}
                    <x-nav-link href="http://localhost:4200" :active="false" target="_blank" class="text-white hover:text-[#CACACA]">
                        {{ __('welcome.go-store') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </x-nav-link>
                </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-[#00747C] hover:text-[#CACACA] focus:outline-none transition ease-in-out duration-150">
                            {{-- Foto y Nombre en el Botón --}}
                            <div class="me-2">
                                <img class="h-10 w-10 md:h-16 md:w-16 rounded-full object-cover" src="{{ route('profile.photo', ['fileName' => Auth::user()->foto]) }}" alt="foto usuario {{ Auth::user()->nombre }}" onerror="this.onerror=null; this.src='/images/creativelogo.png';">                            </div>
                            <div>{{ Auth::user()->nombre }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- ENLACES DENTRO DEL DROPDOWN --}}
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('nav.link_profile') }}
                        </x-dropdown-link>

                        {{-- PRODUCTOS: visible si es Almacén (2) --}}
                        @if(Auth::user()->rol_id == 2 /* || Auth::user()->rol_id == 1 */)
                        <x-dropdown-link :href="route('productos.index')">
                            {{ __('nav.link_products') }}
                        </x-dropdown-link>
                        @endif

                        {{-- USUARIOS: visible solo si es Admin (1) --}}
                        @if(Auth::user()->rol_id == 1)
                        <x-dropdown-link :href="route('admin.usuarios.index')">
                            {{ __('nav.link_users') }}
                        </x-dropdown-link>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('nav.link_logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-4 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white bg-[#00747C] hover:text-[#CACACA] focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden text-white">


        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                {{-- CORRECCIÓN: Usamos nombre y nombre_usuario --}}
                <div class="font-medium text-base text-white">{{ Auth::user()->nombre }}</div>
                <div class="font-medium text-sm text-[#CACACA]">{{ Auth::user()->nombre_usuario }}</div>
            </div>

            <div class="mt-3 space-y-1">

                {{-- ENLACES RESPONSIVE --}}
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('nav.link_profile') }}
                </x-responsive-nav-link>

                {{-- ENLACE DASHBOARD (Panel Principal) --}}
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('messages.dashboard') }}
                </x-responsive-nav-link>

                {{-- ENLACE A LA TIENDA (Frontend) --}}
                {{-- Nota: Usamos HTTPS y el dominio de producción --}}
                <x-responsive-nav-link href="https://creative-eye.duckdns.org" target="_blank" class="flex items-center">
                    {{ __('welcome.go-store') }}
                    {{-- Icono opcional para indicar enlace externo --}}
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </x-responsive-nav-link>
                {{-- PRODUCTOS (RESPONSIVE) --}}
                @if(Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2)
                <x-responsive-nav-link :href="route('productos.index')">
                    {{ __('nav.link_products') }}
                </x-responsive-nav-link>
                @endif

                {{-- USUARIOS (RESPONSIVE) --}}
                @if(Auth::user()->rol_id == 1)
                <x-responsive-nav-link :href="route('admin.usuarios.index')">
                    {{ __('nav.link_users') }}
                </x-responsive-nav-link>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('nav.link_logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
