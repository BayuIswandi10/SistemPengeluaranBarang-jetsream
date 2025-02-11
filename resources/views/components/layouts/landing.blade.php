<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   
            <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
            <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
            <!-- Styles -->
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.4/css/buttons.dataTables.min.css">
            <link href="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.2.1/b-3.2.0/b-html5-3.2.0/r-3.0.3/datatables.min.css" rel="stylesheet">
    
            <!-- Font Awesome -->
            <link rel="stylesheet" href="{{ asset('assets/adminlte3.2/plugins/fontawesome/css/all.min.css') }}">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
            <!-- Tempusdominus Bootstrap 4 -->
            <link rel="stylesheet" href="{{ asset('assets/adminlte3.2/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
            <!-- AdminLTE Theme style -->
            <link rel="stylesheet" href="{{ asset('assets/adminlte3.2/dist/css/adminlte.min.css') }}">
            <!-- overlayScrollbars -->
            <link rel="stylesheet" href="{{ asset('assets/adminlte3.2/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    
            <!-- Custom Header Style -->
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/Style/Header_style.css') }}">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap4.min.css">
    
            <!-- Favicon -->
            <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/Logo C YMI - 2017.png') }}">
    
            <!-- Charset and Meta Tags -->
            <meta charset="utf-8">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <meta name="viewport" content="width=device-width, initial-scale=1">
    
            <!-- Scripts -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            <script src="{{ asset('assets/adminlte3.2/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
            <script>
                $.widget.bridge('uibutton', $.ui.button)
            </script>
            <script src="{{ asset('assets/adminlte3.2/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <script src="{{ asset('assets/adminlte3.2/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
            <script src="{{ asset('assets/adminlte3.2/plugins/moment/moment.min.js') }}"></script>
            <script src="{{ asset('assets/adminlte3.2/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
            <script src="{{ asset('assets/adminlte3.2/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
            <script src="{{ asset('assets/adminlte3.2/dist/js/adminlte.js') }}"></script>
            <script src="{{ asset('assets/adminlte3.2/dist/js/pages/dashboard.js') }}"></script>
            <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.2.1/b-3.2.0/b-html5-3.2.0/r-3.0.3/datatables.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
            <script src="{{ asset('assets/adminlte3.2/plugins/chart.js/Chart.min.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    
            <!-- Scripts -->
            <style>
                /* Hero Section Styling */
                .hero-section {
                    background: linear-gradient(135deg, #6d5efc, #42a5f5);
                    height: 350px;
                    position: auto;
                    overflow: hidden;
                }
        
                 /* Efek hover untuk setiap card */
                .card-hover:hover {
                    transform: scale(1.05); /* Membesarkan card */
                    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); /* Bayangan lebih besar */
                }
        
                .card-hover:hover i {
                    color: #0d6efd; /* Ganti warna ikon */
                }
        
                .card-hover:hover h3 {
                    color: #0d6efd; /* Ganti warna teks judul */
                }
        
                .card-hover {
                    transition: all 0.3s ease; /* Animasi smooth */
                }
        
                .pull-top {
                    position: relative;
                    top: -100px; /* Tarik ke atas */
                    z-index: 3; /* Berada di atas hero-section */
                }
        
                .hero-title {
                    font-size: 2.5rem; /* Ukuran default untuk layar besar */
                }
        
                .hero-subtitle {
                    font-size: 1.25rem; /* Ukuran default untuk layar besar */
                }
        
                .hero-section .text-center {
                    position: relative;
                    z-index: 2;
                }
        
                /* Text Container Styling */
                .text-container {
                    position: relative;
                    z-index: 2; /* Supaya tetap di depan elemen dekoratif */
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 20px;
                }
        
                .text-container h1 {
                    font-size: 2.5rem; /* Ukuran default untuk layar besar */
                }
        
                .text-container p {
                    font-size: 1.25rem; /* Ukuran default untuk layar besar */
                }
        
                /* Decorative Shapes */
                .decorative-elements {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 1;
                    pointer-events: none;
                }
        
                .decorative-elements .circle-1,
                .decorative-elements .circle-2{
                    position: absolute;
                    background: rgba(255, 255, 255, 0.2);
                    filter: blur(10px);
                    animation: float 3s ease-in-out infinite;
                }
        
                .decorative-elements .circle-1 {
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;
                    top: 20%;
                    left: 10%;
                }
        
                .decorative-elements .circle-2 {
                    width: 150px;
                    height: 150px;
                    border-radius: 50%;
                    top: 20%;
                    right: 10%;
                    animation-delay: 1s;
                }
        
        
                /* Animation for floating effect */
                @keyframes float {
                    0% {
                        transform: translateY(0);
                    }
                    50% {
                        transform: translateY(-20px);
                    }
                    100% {
                        transform: translateY(0);
                    }
                }                       
            </style>
    
            <script src="{{ asset('assets/js/instascan.min.js') }}"></script> 
            <!-- Styles -->
            @livewireStyles 
    <title>Document</title>
</head>
    <body>
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
        <div class="rectangle-81"></div>
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false
                });
            </script>
        @endif

        <nav class="navbar main-nav navbar-expand-lg px-2 px-sm-0 py-2 py-lg-0">
            <div class="container">
                <a class="navbar-brand" href="index.html"><img src="{{ asset('assets/img/logo-YMI-DLTP.png') }}" style="height:80px;" alt="logo"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
                <span class="ti-menu"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#tambahDataModal">Pengajuan Pengeluaran Barang</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pengajuan Kendaraan Dinas</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href={{ route('login') }}>Masuk</a></li>
                </ul>
                </div>
            </div>
        </nav>
        
        {{-- Tambah Modal --}}
        <div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Pengeluaran Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('pengeluaran_barang.store') }}" enctype="multipart/form-data" id="tambah_pengeluaran_barang">
                            @csrf
        
                            <!-- Input Fields -->
                            <div class="form-group">
                                <label for="created_by">No Karyawan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="created_by" name="created_by" value="{{ old('created_by') }}" placeholder="Masukan NRP Anda" required autocomplete="off">
                            </div>                
        
                            <div class="form-group">
                                <label for="jenis_kendaraan">Jenis Kendaraan <span class="text-danger">*</span></label>
                                <select class="form-control" id="select-tools" name="jenis_kendaraan" required autocomplete="off">
                                    <option value="" disabled selected>Pilih Jenis Kendaraan</option>
                                    <option value="TRUCK">TRUCK</option>
                                    <option value="PICK UP">PICK UP</option>
                                    <option value="SEDAN">SEDAN</option>
                                    <option value="JEEP">JEEP</option>
                                    <option value="SP. MOTOR">SP. MOTOR</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="lokasi_barang_keluar">Lokasi Barang Keluar  <span class="text-danger">*</span></label>
                                {{-- <input type="text" class="form-control" id="lokasi_barang_keluar" name="lokasi_barang_keluar" placeholder="Masukkan lokasi barang keluar" required autocomplete="off"> --}}
                                <select class="form-control" id="lokasi_barang_keluar" name="lokasi_barang_keluar" required autocomplete="off">
                                    <option value="" disabled selected>Pilih Lokasi Barang Keluar</option>
                                    <option value="P1">P1</option>
                                    <option value="P2">P2</option>
                                </select>
                            </div>

                            <div class="form-group mt-3" id="custom-location-group-destination">
                                <label for="tujuan_pengeluaran_barang">Tujuan Pengeluaran <span class="text-danger">*</span></label>
                                {{-- <input type="text" class="form-control" id="tujuan_pengeluaran_barang" name="tujuan_pengeluaran_barang" placeholder="Masukkan Tujuan Pengeluaran" required autocomplete="off"> --}}
                                <select class="form-control" id="tujuan_pengeluaran_barang" name="tujuan_pengeluaran_barang" required autocomplete="off">
                                    <option value="" disabled selected>Pilih Lokasi Barang Keluar</option>
                                    <option value="P1">P1</option>
                                    <option value="P2">P2</option>
                                </select>
                            </div>

        
                            <!-- Barang Keluar Table -->
                            <div class="form-group">
                                <label>Detail Barang Keluar <span class="text-danger">*</span></label>
                                <table id="barangTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="nomor">1</td>
                                            <td><input type="text" name="barang_ids[]" class="form-control" placeholder="Nama Barang" required autocomplete="off"></td>
                                            <td><input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" required autocomplete="off"></td>
                                            <td>
                                                <select name="satuan[]" class="form-control" required>
                                                    <option value="" disabled selected>Pilih Satuan</option>
                                                    <option value="unit">Unit</option>
                                                    <option value="pcs">PCS</option>
                                                </select>
                                            </td>
                                            <td><input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan" required autocomplete="off"></td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBox(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success btn-sm" onclick="tambahComboBox()">
                                    <i class="fas fa-plus"></i> Tambah Barang
                                </button>
                            </div>
        
                            <!-- Submit Button -->
                            <div class="form-group d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>


        {{ $slot }}


    </body>
    <script>


        let counter = 1;

        function tambahComboBox() {
            const container = document.getElementById('barangTable');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td class="nomor">${counter += 1}</td>
                <td><input type="text" name="barang_ids[]" class="form-control" placeholder="Nama Barang" required autocomplete="off"></td>
                <td><input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" required autocomplete="off"></td>
                <td>
                    <select name="satuan[]" class="form-control" required>
                        <option value="" disabled selected>Pilih Satuan</option>
                        <option value="unit">Unit</option>
                        <option value="pcs">PCS</option>
                    </select>
                </td>
                <td><input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan" required autocomplete="off"></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBox(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            container.appendChild(newRow);
            updateNomor();
        }

        function hapusComboBox(button) {
            const container = document.getElementById('barangTable');
            const rows = container.getElementsByTagName('tr');
            if (rows.length > 1) {
                const row = button.closest('tr');
                
                // SweetAlert konfirmasi untuk baris selain baris terakhir
                Swal.fire({
                    icon: 'warning',
                    title: 'Apakah Anda yakin?',
                    text: 'Baris ini akan dihapus.',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        row.remove();
                        updateNomor();
                    }
                });
            } else {
                // Ganti alert dengan SweetAlert untuk baris terakhir
                Swal.fire({
                    icon: 'info',
                    title: 'Tidak bisa menghapus baris terakhir.',
                    text: 'Harap tambahkan baris baru jika perlu.',
                    confirmButtonText: 'OK'
                });
            }
        }

        function updateNomor() {
        const rows = document.querySelectorAll('#barangTable .nomor');
            rows.forEach((cell, index) => {
                cell.textContent = index + 1;
            });
        }

        var $select = $('#select-tools').selectize({

        create: true
        });

        $(document).ready(function() {
            $('#lokasi_barang_keluar').selectize({
                create: true,
                sortField: 'text'
            });

            $('#tujuan_pengeluaran_barang').selectize({
                create: true,
                sortField: 'text'
            });
        });


        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        var control = $select[0].selectize;

        $('#button-clear').on('click', function() {
        control.clear();
        });

        $('#button-clearoptions').on('click', function() {
        control.clearOptions();
        });

        $('#button-addoption').on('click', function() {
        control.addOption({
            id: 4,
            title: 'Something New',
            url: 'http://google.com'
        });
        });

        $('#button-additem').on('click', function() {
        control.addItem(2);
        });

        $('#button-maxitems2').on('click', function() {
        control.setMaxItems(2);
        });

        $('#button-maxitems100').on('click', function() {
        control.setMaxItems(100);
        });

        $('#button-setvalue').on('click', function() {
        control.setValue([2, 3]);
        });
    </script>
    




</html>