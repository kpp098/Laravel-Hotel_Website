<title>Hotel_Century</title>
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/short.jpg') }}">
<x-guest-layout>

    <x-jet-authentication-card>
        <a class="home" href="/">home</a>
        <x-slot name="logo">
            <img class="img" width="100px" src="{{ asset('assets/images/logo.png') }}">
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (Session::has('statuss'))
            <div id="status" class="mb-4 font-medium text-sm text-green-600">
                <strong>Congrats !</strong> {{ Session::get('statuss') }}
            </div>
        @endif
        <script>
            var message = document.getElementById("status")
            message.onclick = setTimeout(function() {
                message.style.display = 'none';
            }, 4000);
        </script>
        {{ Session::forget('statuss') }}





        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="button">
                <x-jet-button class="ml-4">
                    {{ __('Log in') }}
                </x-jet-button>



                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}" style="margin-left:20px;">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif


            </div><br>
            <div style="text-align:center">
                Or <br>
                <u><a class="register "href="/register">Register Now</a></u>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
