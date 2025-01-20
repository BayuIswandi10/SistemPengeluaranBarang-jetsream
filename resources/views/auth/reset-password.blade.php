<x-guest-layout>
<head>
        <style>
            body {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
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

        <div class="login-box mt-5">
            <div class="card card-outline card-primary login-card">
                <div class="card-body">  
                    <div class="text-center">
                        <b class="h2">Pengeluaran Barang</b>
                    </div>
                    <hr>
                    <h4 class="login-box-msg">Reset Kata Sandi</h4>
                
                    <div class="mb-4 text-sm text-gray-600">
                        {{ __('Buat ulang kata sandi baru') }}
                    </div>

                   <!-- Tampilkan error validasi -->
                    <x-validation-errors class="mb-4" />    

                    <!-- Tampilkan status session -->
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="block">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Kata Sandi') }}" />
                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password_confirmation" value="{{ __('Konfirmasi Ulang Kata Sandi') }}" />
                            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="btn btn-primary mr-2" style="background-color: #4B687E; border-radius:8px;">
                                {{ __('Reset Kata Sandi') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
    </body>
</x-guest-layout>
