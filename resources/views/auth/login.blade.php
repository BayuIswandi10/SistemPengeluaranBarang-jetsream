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
        <div class="nav-static-top d-flex justify-content-between align-items-center p-3 bg-light">
            <div class="float-left">
                <a href="#">
                    <img class="mt-3 ml-4" src="{{ asset('assets/img/logo YMI-DLT.png') }}" style="height:40px;">
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
                            <x-label for="email" value="{{ __('Nrp/Email') }}" />
                            <x-input id="loginkey" class="form-control" type="text" name="loginkey" :value="old('loginkey')" required autofocus autocomplete="off" />
                        </div>

                        <div class="form-group mt-4">
                            <x-label for="password" value="{{ __('Sandi') }}" />
                            <x-input id="password" class="form-control" type="password" name="password" required autocomplete="off" />
                        </div>

                        <div class="form-group mt-4 flex items-center justify-between">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                                    {{ __('Lupa kata sandi ?') }}
                                </a>
                            @endif
                        </div>
                        
                   
                        <div class="flex items-center justify-end mt-4">
                            <a href="/">
                                <x-button type="button" class="btn btn-primary mr-2" style="background-color: #4B687E; border-radius:2px;">
                                    {{ __('Kembali') }}
                                </x-button>
                            </a>

                            <button type="submit" class="btn btn-primary w-60" style="background-color: #3674A7; border-color: #3674A7;">
                                {{ __('Masuk') }}
                            </button>

                            
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tombol untuk membuka modal -->
            <a href="{{ route('kamera') }}" id="openScanner">Scan QR</a>


        </div>


   

        {{-- <script>
            let qrScanner;
        
            document.getElementById('openScanner').addEventListener('click', function () {
                document.getElementById('qrScannerModal').style.display = 'block';
                startScanner();
            });
        
            function startScanner() {
                const videoElem = document.getElementById('qr-video');
                qrScanner = new QrScanner(videoElem, result => {
                    console.log('QR Code:', result);
                    document.getElementById('scan-result').innerText = "Hasil Scan: " + result;
                    closeModal();
                });
                qrScanner.start();
            }
        
            function closeModal() {
                document.getElementById('qrScannerModal').style.display = 'none';
                if (qrScanner) {
                    qrScanner.stop();
                }
            }
        </script>    --}}


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


