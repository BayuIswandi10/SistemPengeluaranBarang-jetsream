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
                    <h4 class="login-box-msg">Lupa Kata Sandi</h4>
                
                    <div class="mb-4 text-sm text-gray-600">
                        {{ __('Lupa kata sandi?, tuliskan email anda untuk kami
                             kirimkan link reset kata sandi, untuk membuat ulang kata sandi baru') }}
                    </div>

                   <!-- Tampilkan error validasi -->
                    <x-validation-errors class="mb-4" />    

                    <!-- Tampilkan status session -->
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="block">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('login') }}">
                                <x-button type="button" class="btn btn-primary mr-2" style="background-color: #4B687E; border-radius:8px;">
                                    {{ __('Kembali') }}
                                </x-button>
                            </a>

                            <x-button type="submit" style="background-color: #3674A7;">
                                {{ __('Reset') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</x-guest-layout>
