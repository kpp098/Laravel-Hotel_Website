<title>Hotel_Century</title>
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/short.jpg') }}">
<x-guest-layout>
    <x-jet-authentication-card>
        <a class="home" href="/">home</a>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
            <img class="img" width="100px" src="{{ asset('assets/images/logo.png') }}">
        </x-slot>
        @if (session()->has('wrong'))
            <div id="status" class="mb-4 font-medium text-sm text-red-600">
                <strong>OOPS !</strong> {{ session()->get('wrong') }}
            </div>
        @endif
        @if (session()->has('resent'))
            <div id="status" class="mb-4 font-medium text-sm text-green-600">
                <strong>{{ session()->get('resent') }}</strong>
            </div>
        @endif



        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ url('email/confirm') }}">
            @csrf
            @php
                $data = Session::get('email');
            @endphp


            <div>
                <x-jet-label for="name" value="Otp Sent to - {{ $data }}"
                    style="color:yellowgreen;font-size:100%" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="otp"
                    placeholder="Enter Otp here" required autofocus autocomplete="name" />
            </div>
            <br>
            <x-jet-button class="ml-4">
                {{ 'Submit' }}
            </x-jet-button><a href="{{ url('resend') }}">Resend Otp</a>
            </div>
        </form>

    </x-jet-authentication-card>
</x-guest-layout>
<script>
    var message = document.getElementById("status")
    message.onclick = setTimeout(function() {
        message.style.display = 'none';
    }, 8000);
</script>


<style>
    .alert {
        padding: 20px;
        background-color: #f44336;
        color: white;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
</style>
