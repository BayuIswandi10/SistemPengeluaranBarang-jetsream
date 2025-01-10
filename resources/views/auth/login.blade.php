<x-guest-layout>
    <head>
        <style>
            body {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
                background-image: url('{{ asset('assets/adminlte3.2/dist/img/IMG_Background.jpg') }}');
                background-repeat: no-repeat;
                background-size: cover;
            }

            .login-box {
                width: 400px;
            }

            .nav-static-top {
                top: 0;
                left: 0;
                right: 0;
                position: fixed;
                height: 70px;
                width: 100% !important;
                box-shadow: 0px 2px 0px 0px #eee;
                background-color: white;
                z-index: 4;
                opacity: 0.9;
            }

            .login-card {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }
        </style>
    </head>

    <body>
        <div class="nav-static-top">
            <div class="float-left">
                <a href="#">
                    <img class="mt-3 ml-4" src="{{ asset('assets/img/logo A YMI - 2017.png') }}" style="height:40px;">
                </a>
            </div>
        </div>

        <div class="login-box">
            <div class="card card-outline card-primary login-card">
                <div class="card-body">
                    <div class="text-center">
                        <b class="h2">Pengeluaran Barang</b>
                    </div>
                    <hr>
                    <h4 class="login-box-msg">Masuk User</h4>

                    <x-validation-errors class="mb-4" />

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        </div>

                        <div class="form-group mt-4">
                            <x-label for="password" value="{{ __('Password') }}" />
                            <x-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
                        </div>

                        <div class="form-group mt-4">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>
                        
                        <div class="text-center mt-4">
                            @if (Route::has('password.request'))
                                <a class="btn btn-danger" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                            <button type="submit" class="btn btn-primary ms-2">
                                {{ __('Log in') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif
    </body>
</x-guest-layout>

{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}

