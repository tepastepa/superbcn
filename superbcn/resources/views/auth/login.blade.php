<x-guest-layout>
    <div class="w-full sm:max-w-md mt-16 mb-16 px-6 mt-6 mb-8 bg-white overflow-hidden rounded-2xl">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('logo.svg') }}" alt="Zephyr Logo" class="h-5 w-auto mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Welcome back</h2>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <x-primary-button class="mt-6 w-full justify-center">
                {{ __('Log in') }}
            </x-primary-button>

            <div class="mt-6 text-center">

                @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:text-blue-800" href="{{ route('password.request') }}">
                            {{ __('I forgot my password') }}
                        </a>
                @endif

            </div>

            <div class="mt-2 text-center">
                <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:text-blue-800 ml-1">I don't have an account</a>
            </div>
        </form>
    </div>
</x-guest-layout>
