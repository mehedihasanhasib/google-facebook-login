<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center">
            <!-- google login -->
            <div class="block mt-4">
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ url('/login/google') }}">
                        <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png">
                    </a>
                </div>
            </div>

            <!-- facebook login -->
            <div class="block mt-4">
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ url('/auth/facebook') }}" style="background-color: #183153"
                        class="inline-flex items-center px-2 float-left py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 h-10 px-2 py-2 mt-2 font-semibold text-xs text-white float-left transition-colors duration-150 rounded-lg uppercase focus:shadow-outline0 bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                        <img src="https://www.cdnlogo.com/logos/f/9/facebook.svg" class="w-8 m-0 p-0">
                        Login with Facebook
                    </a>
                </div>
            </div>
        </div>



        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
