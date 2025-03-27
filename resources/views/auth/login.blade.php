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
                    <img class="mt-3 ml-4" src="{{ asset('assets/img/logo-YMI-DLTP.png') }}" style="height:80px;">
                </a>
            </div>

        </div>

        <div class="container d-flex justify-content-center align-items-center mt-5 min-vh-100">
            <div class="login-box w-150" style="max-width: 300px;">
                <div class="card card-outline card-primary login-card shadow-lg">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <b class="h2">Masuk</b>
                        </div>
                        <hr>

                        <x-validation-errors class="mb-4" />

                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group mt-3">
                                <x-label for="email" value="{{ __('Nrp/Email') }}" />
                                <x-input id="loginkey" class="form-control" type="text" name="loginkey" :value="old('loginkey')" required autofocus autocomplete="off" />
                            </div>

                            <div class="form-group mt-3">
                                <x-label for="password" value="{{ __('Sandi') }}" />
                                <x-input id="password" class="form-control" type="password" name="password" required autocomplete="off" />
                            </div>


                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="/" class="btn btn-secondary w-50 me-2">
                                    {{ __('Kembali') }}
                                </a>
                                <button type="submit" class="btn btn-primary w-50">
                                    {{ __('Masuk') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tombol Scan QR -->
                <div class="d-flex justify-content-center align-items-center mt-3">
                    <div class="card text-center p-3 shadow-lg" style="width: 80px; border-radius: 10px;">
                        <a href="{{ route('kamera') }}" id="openScanner" class="text-decoration-none text-dark">
                            <i class="fa-solid fa-qrcode fa-2x"></i>
                            <h6 class="mt-2">Scan</h6>
                        </a>
                    </div>
                </div>
            </div>
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


