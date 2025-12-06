<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('error.404_title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-2xl font-bold text-red-500 mb-4">
                        ⚠️ {{ __('error.404_header') }} ⚠️
                    </h3>

                    <p class="text-lg">
                        {{ __('error.404_info') }}
                    </p>

                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <p class="mb-3">{{ __('error.go_back_prompt') }}</p>

                        @auth
                            <a href="{{ route('dashboard') }}" class="mr-4">
                                <x-primary-button type="button">
                                    {{ __('error.button_dashboard') }}
                                </x-primary-button>
                            </a>
                        @else
                            <a href="/" class="mr-4">
                                <x-primary-button type="button">
                                    {{ __('error.button_home') }}
                                </x-primary-button>
                            </a>
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
