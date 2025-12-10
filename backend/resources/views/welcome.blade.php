<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> {{ __('welcome.title') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <script src="https://cdn.tailwindcss.com"></script>

        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            brand: {
                                teal: '#00747C',       /* Teal Principal */
                                light: '#00BBC9',      /* Teal Claro (Acentos) */
                                graylight: '#CACACA',  /* Gris Claro */
                                graymed: '#878787',    /* Gris Medio */
                                graydark: '#202022',   /* Gris Oscuro (Base neutra) */
                            }
                        },
                        fontFamily: {
                            // Aquí definimos Poppins para toda la web
                            sans: ['Poppins', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="antialiased font-sans">

        <nav class="bg-brand-teal text-white p-4 shadow-md fixed w-full z-50 top-0">
            <div class="container mx-auto flex justify-between items-center px-4">

                <div class="flex items-center space-x-2">
                    <div class="font-bold text-2xl tracking-wide flex items-center">
                        <img src="{{ asset('images/creativelogo.png') }}" alt="Creative Eye" class="block h-16 md:h-28 w-auto">
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold hover:text-brand-light transition"> {{ __('welcome.my-panel') }}</a>
                        @else
                            <a href="{{ route('login') }}" class="bg-white text-brand-teal px-4 py-2 rounded-md font-bold hover:bg-brand-graylight transition shadow-sm">{{ __('welcome.login') }}</a>

{{--                             @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="font-semibold hover:text-brand-light transition">
                                    {{ __('welcome.register') }}
                                </a>
                            @endif --}}
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

  <div class="relative w-full mt-[80px] md:mt-[112px] h-[calc(100vh-80px)] md:h-[calc(100vh-112px)] overflow-hidden">                <img src="{{ asset('hero-pic.png') }}" alt="Fondo" class="absolute top-0 left-0 w-full h-full object-cover object-top z-0">
            <div class="absolute inset-0 bg-brand-graydark bg-opacity-60"></div>

            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">

                <h1 class="text-white text-[48px] font-semibold drop-shadow-lg mb-6 leading-tight">
                    Creative  <span class="text-brand-light">Eye</span>
                </h1>

                <p class="text-brand-graylight text-xl md:text-2xl mb-8 max-w-2xl drop-shadow-md font-normal">
                     {{ __('welcome.admin-panel') }}
                </p>
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-brand-teal hover:bg-brand-light text-white font-semibold py-3 px-8 rounded shadow-lg transition transform hover:scale-105 border border-transparent">
                        {{ __('welcome.store') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-brand-teal hover:bg-brand-light text-white font-semibold py-3 px-8 rounded shadow-lg transition transform hover:scale-105 border border-transparent">
                        {{ __('welcome.store') }}
                    </a>
                @endauth
            </div>
        </div>

    </body>
</html>
