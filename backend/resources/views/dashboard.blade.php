
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-brand-teal leading-tight">
            {{ __('messages.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border-l-4 border-brand-teal">
                <div class="p-6 text-brand-graydark">
                    <h3 class="text-2xl font-bold mb-2">>{{ __('messages.welcome_user', ['name' => Auth::user()->nombre]) }}</h3>
                    <p class="text-brand-graymed">
                        {{ __('messages.welcome_intro') }} <strong>Creative Eye</strong>.
                        {{ __('messages.logged_as') }}
                        <span class="font-bold text-brand-teal">
                            @if(Auth::user()->rol_id == 1) {{ __('messages.role_admin') }}
                            @elseif(Auth::user()->rol_id == 2) {{ __('messages.role_warehouse') }}
                            @else {{ __('messages.role_client') }}
                            @endif
                        </span>.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                @if(Auth::user()->rol_id == 1)
                <a href="{{ route('admin.usuarios.index') }}" class="block group">
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition transform hover:-translate-y-1 border border-gray-100 h-full">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-bold text-brand-graydark group-hover:text-brand-teal transition">{{ __('messages.card_users_title') }}</h4>
                            <div class="bg-brand-teal text-white p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                        </div>
                        <p class="text-sm text-brand-graymed">{{ __('messages.card_users_desc') }}</p>
                    </div>
                </a>
                @endif

                @if(Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2)
                <a href="{{ route('productos.index') }}" class="block group">
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition transform hover:-translate-y-1 border border-gray-100 h-full">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-bold text-brand-graydark group-hover:text-brand-teal transition">{{ __('messages.card_products_title') }}</h4>
                            <div class="bg-brand-teal text-white p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                        </div>
                        <p class="text-sm text-brand-graymed">{{ __('messages.card_products_desc') }}</p>
                    </div>
                </a>
                @endif

                <a href="{{ route('profile.edit') }}" class="block group">
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition transform hover:-translate-y-1 border border-gray-100 h-full">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-bold text-brand-graydark group-hover:text-brand-teal transition">{{ __('messages.card_profile_title') }}</h4>
                            <div class="bg-brand-teal text-white p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                        </div>
                        <p class="text-sm text-brand-graymed">{{ __('messages.card_profile_desc') }}</p>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
