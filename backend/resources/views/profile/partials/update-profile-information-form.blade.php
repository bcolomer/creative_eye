@php
    /** @var \App\Models\User $user */
@endphp
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('profile.info_title') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('profile.info_description') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nombre" :value="__('usuario.field_name')" />
            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full " :value="old('nombre', $user->nombre)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
        </div>

        <div>
            <x-input-label for="nombre_usuario" :value="__('usuario.field_email_info')" />
                      {{-- bloquea escribir en nombre de usuario para evitar modificarlo con readonly --}}

            <x-text-input id="nombre_usuario" name="nombre_usuario" type="email" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700" :value="old('nombre_usuario', $user->nombre_usuario)" required autocomplete="username" readonly />
            <x-input-error class="mt-2" :messages="$errors->get('nombre_usuario')" />
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('profile.email_unverified_info') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('profile.button_resend_verification') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('profile.verification_link_sent') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        <div class="mt-4">
            <x-input-label for="foto" :value="__('profile.field_photo_optional')" />
            <img  class="{{--h-16 w-16--}} rounded-md object-cover my-2"  src="{{ route('profile.photo', ['fileName' => $user->foto]) }} "
     alt="{{ $user->nombre }}" onerror="this.onerror=null; this.src='/images/creativelogo.png';">
            <x-text-input id="foto" name="foto" type="file" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.button_save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
