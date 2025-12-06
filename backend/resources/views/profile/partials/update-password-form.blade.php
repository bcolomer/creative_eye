<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('profile.update_password_title') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('profile.update_password_info') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <input type="text" name="username" value="{{ $user->nombre_usuario }}" autocomplete="username" style="display:none;" readonly>

        <div x-data="{ show: false }">
            <x-input-label for="update_password_current_password" :value="__('profile.field_current_password')" />

            <div class="relative">
                <x-text-input id="update_password_current_password" name="current_password"
                            x-bind:type="show ? 'text' : 'password'"
                            class="mt-1 block w-full pr-10"  autocomplete="new-password" />

                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-500 hover:text-brand-teal focus:outline-none">
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
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="update_password_password" :value="__('profile.field_new_password')" />

            <div class="relative">
                <x-text-input id="update_password_password" name="password"
                            x-bind:type="show ? 'text' : 'password'"
                            class="mt-1 block w-full pr-10" autocomplete="new-password" />

                <button type="button"
                        @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center focus:outline-none">

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
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="update_password_password_confirmation" :value="__('auth.field_confirm_password')" />

            <div class="relative">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation"
                            x-bind:type="show ? 'text' : 'password'"
                            class="mt-1 block w-full pr-10" autocomplete="new-password" />

                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-500 hover:text-brand-teal focus:outline-none">
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
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.button_save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('profile.saved_message') }}</p>
            @endif
        </div>
    </form>
</section>
