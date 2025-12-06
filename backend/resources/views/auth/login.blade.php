<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- nombre de usuario -->
        <div>
            <x-input-label for="nombre_usuario" :value="__('auth.field_username')" />
            <x-text-input id="nombre_usuario" class="block mt-1 w-full" type="text" name="nombre_usuario" :value="old('nombre_usuario')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('nombre_usuario')" class="mt-2" />
        </div>

        <!-- Password -->
      <div class="mt-4" x-data="{ show: false }">
            <x-input-label for="password" :value="__('auth.field_password')" />

            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                                x-bind:type="show ? 'text' : 'password'"
                                name="password"
                                required autocomplete="current-password" />

                <button type="button"
                        @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-500 hover:text-brand-teal focus:outline-none">


                        <img x-show="show"
                         src="{{ asset('images/ver.svg') }}"
                         alt="Ver contraseña"
                         class="w-5 h-5">

                        <img x-show="!show"
                         src="{{ asset('images/no-ver.svg') }}"
                         alt="Ocultar contraseña"
                         class="w-5 h-5">
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('auth.remember_me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                   {{ __('auth.forgot_password') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('auth.button_login') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
