
<x-guest-layout>
    <!-- Tambahkan CSS untuk mendukung responsivitas -->
    <style>
        @media (max-width: 767px) {
            #legendKendaraan {
                font-size: 14px; /* Kurangi ukuran font untuk layar kecil */
            }
            #legendKendaraan .legend-color {
                width: 12px !important; /* Ukuran kotak legenda lebih kecil di mobile */
                height: 12px !important;
            }
            #legendKendaraan span:not(.legend-color) {
                font-size: 12px; /* Ukuran teks lebih kecil di mobile */
            }
            .modal-body {
                padding: 15px; /* Kurangi padding untuk menghemat ruang */
            }
        }
    </style>
    
    <style>
        .nav-link {
            cursor: pointer;
        }
        .fc-daygrid-day {
            transition: background-color 0.2s ease;
        }

        .fc-daygrid-day:hover {
            background-color: #f0f8ff; /* Warna biru muda lembut */
            border-radius: 4px;
        }
        
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
            top: -60px; /* Tarik ke atas */
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

    <style>
        .legend-color {
            width: 16px;
            height: 16px;
            display: inline-block;
            border-radius: 4px;
        }
    </style>

    <style>
        /* Pastikan modal tidak lebih besar dari layar */
        @media (max-width: 768px) {
            .modal-dialog {
                max-width: 95%;
                margin: 1.75rem auto;
            }
        }

        /* Pastikan isi modal bisa di-scroll jika terlalu panjang */
        .modal-body {
            overflow-x: auto;
        }

    </style>

    <style>
        /* Modal benar-benar lebar, hampir penuh, tetap menyamping */
        .modal-slide-side {
            width: calc(100% - 2rem); /* Ubah menjadi 100% untuk memenuhi lebar penuh */
            max-width: 100%; /* Pastikan tidak dibatasi oleh max-width */
            margin: 1rem; /* Kurangi margin untuk lebih dekat ke tepi */
        }

        /* Pastikan modal-content dan modal-header mengisi lebar penuh */
        .modal-slide-side .modal-content,
        .modal-slide-side .modal-header {
            width: 100%;
            border-radius: 0; /* Hilangkan border-radius jika tidak diinginkan */
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1.25rem;
        }

        .modal-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 500;
        }

        .modal-header .close {
            padding: 0.5rem 0.75rem;
            margin: -0.5rem -0.75rem -0.5rem auto;
        }

        /* Responsivitas */
        @media (max-width: 767px) {
            .modal-slide-side {
                width: calc(100% - 1rem); /* Kurangi margin di mobile */
                margin: 0.5rem;
            }
            .modal-header {
                padding: 0.5rem 1rem;
            }
            .modal-title {
                font-size: 1rem;
            }
            #legendKendaraan .legend-color {
                width: 12px !important;
                height: 12px !important;
            }
            #legendKendaraan span:not(.legend-color) {
                font-size: 12px;
            }
            .modal-body {
                padding: 15px;
            }
        }
    </style>

    <style>
        /* Semua tombol di FullCalendar */
        .fc .fc-button {
            background-color: #084298 !important; /* Lebih gelap */
            border-color: #084298 !important;
            color: #ffffff !important;
            font-weight: bold;
            border-radius: 0.375rem;
        }

        /* Hover */
        .fc .fc-button:hover,
        .fc .fc-button:focus {
            background-color: #0b5ed7 !important; /* Hover lebih terang */
            border-color: #0a58ca !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        /* Saat tombol aktif (diklik) */
        .fc .fc-button:active,
        .fc .fc-button.fc-button-active {
            background-color: #0d6efd !important; /* Lebih terang dari default */
            border-color: #0d6efd !important;
            color: #ffffff !important;
        }

        /* Tombol "today" (default gelap, aktif terang) */
        .fc .fc-today-button {
            background-color: #084298 !important;
            border-color: #084298 !important;
            color: #ffffff !important;
        }

        /* Hover & klik untuk today */
        .fc .fc-today-button:hover,
        .fc .fc-today-button:focus,
        .fc .fc-today-button:active {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            color: #ffffff !important;
        }



    </style>

    <style>
        .form-area .custom-input,
        .form-area .custom-select {
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            background-color: #fff;
        }


        .custom-input:focus,
        .custom-select:focus {
            border-color: #5A6ACF;
            box-shadow: 0 0 0 0.2rem rgba(90, 106, 207, 0.25);
            outline: none;
        }

        /* Untuk readonly input agar tampil mirip disabled select */
       input[readonly].custom-input {
            background-color: #f8f9fa; /* Tetap terang */
            color: #6c757d;            /* Abu-abu redup */
            cursor: not-allowed;
        }


        /* Jika input berada dalam tabel */
        td .custom-input,
        td .custom-select {
            margin: 0;  /* Hindari spasi aneh di tabel */
        }
        
    </style>

    <style>
        /* Additional CSS for license plate fields */
        .license-plate-container .custom-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
        }

        @media (max-width: 576px) {
            .license-plate-container {
                justify-content: center;
                gap: 6px;
            }
            
            .license-plate-container .custom-input {
                width: 50px !important;
                font-size: 14px;
            }
            
            .license-plate-container input[id="number_part"] {
                width: 65px !important;
            }
        }
    </style>


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
                <a class="navbar-brand"><img src="{{ asset('assets/img/logo-YMI-DLTP.png') }}" style="height:80px;" alt="logo"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
                <span class="ti-menu"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kamera') }}" id="openScanner" class="text-decoration-none text-dark">Scan Pengajuan</a></li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#tambahDataModal">Pengajuan Pengeluaran Barang</a></li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#calendarModal">Pengajuan Kendaraan Dinas</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href={{ route('login') }}>Masuk</a></li>
                </ul>
                </div>
            </div>
            
            {{-- Tambah Pengeluaran Barang Modal --}}
            <div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="tambahDataModalLabel">Ajukan Pengeluaran Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="form-area modal-body">
                            <form method="POST" action="{{ route('pengeluaran_barang.store') }}" enctype="multipart/form-data" id="tambah_pengeluaran_barang">
                                @csrf
            
                                <!-- Input Fields -->
                               <div class="form-group">
                                    <label for="created_by">No Karyawan <span class="text-danger">*</span></label>
                                    {{-- <input type="text" class="form-control" id="created_by" name="created_by" value="{{ old('created_by') }}" placeholder="Masukan NRP Anda" required autocomplete="off"> --}}
                                    <select class="form-control selectize" id="created_by_barang" name="created_by" required>
                                        <option value="" disabled selected>Pilih Karyawan</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="kategori_pengeluaran">Kategori Pengeluaran <span class="text-danger">*</span></label>
                                    <select class="form-control" id="kategori_pengeluaran" name="kategori_pengeluaran" required>
                                        <option value="" disabled selected>Pilih Kategori Pengeluaran</option>
                                        <option value="0">Non Scrap</option>
                                        <option value="1">Scrap</option>
                                    </select>
                                </div>
                                
                                <div class="form-group" id="pembawa_scrap_group">
                                    <label for="pembawa_scrap">Pembawa <span class="text-danger">*</span></label>
                                    <input type="text" class="custom-input" id="pembawa_scrap" name="pembawa_scrap" placeholder="Masukkan Nama Pembawa Scrap" autocomplete="off">
                                </div>                                
            
                                <div class="form-group">
                                    <label for="jenis_kendaraan">Jenis Kendaraan <span class="text-danger">*</span></label>
                                    <select class="form-control" id="select-tools" name="jenis_kendaraan" required autocomplete="off">
                                        <option value="" disabled selected>Pilih Jenis Kendaraan</option>
                                        <option value="TRUCK">TRUCK</option>
                                        <option value="PICK UP">PICK UP</option>
                                        <option value="SP. MOTOR">SP. MOTOR</option>
                                        <option value="KENDARAAN PRIBADI">KENDARAAN PRIBADI</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="no_polisi">No Polisi <span class="text-danger">*</span></label>
                                    
                                    <!-- License Plate Separated Fields -->
                                    <div class="license-plate-container" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                        <input type="text" 
                                            class="custom-input" 
                                            id="area_code" 
                                            name="area_code" 
                                            placeholder="B" 
                                            maxlength="2"
                                            style="width: 60px; text-align: center; text-transform: uppercase;"
                                            required>
                                        
                                        <span style="font-size: 18px; color: #666;">-</span>
                                        
                                        <input type="text" 
                                            class="custom-input" 
                                            id="number_part" 
                                            name="number_part" 
                                            placeholder="1234" 
                                            maxlength="4"
                                            style="width: 80px; text-align: center;"
                                            required>
                                        
                                        <span style="font-size: 18px; color: #666;">-</span>
                                        
                                        <input type="text" 
                                            class="custom-input" 
                                            id="letter_code" 
                                            name="letter_code" 
                                            placeholder="ACD" 
                                            maxlength="3"
                                            style="width: 70px; text-align: center; text-transform: uppercase;"
                                            required>
                                    </div>
                                    
                                    <!-- Hidden input for complete license plate -->
                                    <input type="hidden" id="no_polisi" name="no_polisi" value="">
                                    
                                    <!-- Error message -->
                                    <small id="no_polisi_error" class="text-danger" style="display: none;">
                                        Mohon lengkapi semua bagian nomor polisi dengan benar.
                                    </small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="lokasi_barang_keluar">Lokasi Barang Keluar  <span class="text-danger">*</span></label>
                                    {{-- <input type="text" class="form-control" id="lokasi_barang_keluar" name="lokasi_barang_keluar" placeholder="Masukkan lokasi barang keluar" required autocomplete="off"> --}}
                                    <select class="form-control" id="lokasi_barang_keluar" name="lokasi_barang_keluar" required autocomplete="off">
                                        <option value="" disabled selected>Pilih atau ketik Lokasi Barang Keluar</option>
                                        <option value="P1">P1</option>
                                        <option value="P2">P2</option>
                                    </select>
                                </div>

                                <div class="form-group mt-3" id="custom-location-group-destination">
                                    <label for="tujuan_pengeluaran_barang">Tujuan Pengeluaran <span class="text-danger">*</span></label>
                                    {{-- <input type="text" class="form-control" id="tujuan_pengeluaran_barang" name="tujuan_pengeluaran_barang" placeholder="Masukkan Tujuan Pengeluaran" required autocomplete="off"> --}}
                                    <select class="form-control" id="tujuan_pengeluaran_barang" name="tujuan_pengeluaran_barang" required autocomplete="off">
                                        <option value="" disabled selected>Pilih atau ketik Tujuan Barang Keluar</option>
                                        <option value="P1">P1</option>
                                        <option value="P2">P2</option>
                                    </select>
                                </div>
                                <small id="lokasi_tujuan_error" class="text-danger" style="display: none;">
                                        Lokasi Barang Keluar dan Tujuan Pengeluaran tidak boleh sama.
                                </small>
            
                                    <!-- Barang Keluar Table -->
                                    <div class="form-group">
                                        <label>Detail Barang Keluar <span class="text-danger">*</span></label>
                                        <table id="barangTableTambah" class="table table-striped table-bordered">
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
                                                    <td><input type="text" name="barang_ids[]" class="custom-input" placeholder="Nama Barang" required autocomplete="off"></td>
                                                    <td><input type="text" name="jumlah[]" class="custom-input jumlah-input" placeholder="Jumlah"required autocomplete="off"></td>
                                                    <td>
                                                        <select name="satuan[]" class="custom-input" required>
                                                            <option value="" disabled selected>Pilih Satuan</option>
                                                            <option value="unit">Unit</option>
                                                            <option value="pcs">PCS</option>
                                                            <option value="kg">KG</option>
                                                            <option value="jumbo bag">JUMBO BAG</option>
                                                            <option value="drum">DRUM</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="keterangan[]" class="custom-input" placeholder="Keterangan" autocomplete="off"></td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBox(this)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="tambahComboBox()">
                                            <i class="fas fa-plus"></i> Tambah Barang
                                        </button>
                                    </div>
            
                                <!-- Submit Button -->
                                <div class="form-group d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                            @if(session('clear_local_storage'))
                            <script>
                                localStorage.removeItem('barang_keluar_data');
                            </script>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lihat Kalender Pemakaian Kendaraan --}}
            <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-slide-side" role="document" style="max-width: 100%;">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="tambahDinasModalLabel">Lihat Kalender Pemakaian Kendaraan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="form-area modal-body">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                                <!-- Input bulan -->
                                <div class="mb-3 mb-md-0">
                                    <label for="monthPickerGlobal">Pilih Bulan:</label>
                                    <input type="month" id="monthPickerGlobal" class="custom-input" style="max-width: 250px;">
                                </div>

                                <!-- Legend kendaraan -->
                                <div class="d-flex flex-wrap" id="legendKendaraan">
                                    <div class="d-flex align-items-center mb-2 mb-md-0 mr-3">
                                        <span class="legend-color" style="background-color: #28a745; width: 16px; height: 16px; display: inline-block; margin-right: 8px;"></span>
                                        <span>Kendaraan Kantor</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 mb-md-0 mr-3">
                                        <span class="legend-color" style="background-color: #007bff; width: 16px; height: 16px; display: inline-block; margin-right: 8px;"></span>
                                        <span>Kendaraan Pribadi</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2 mb-md-0">
                                        <span class="legend-color" style="background-color: #ffc107; width: 16px; height: 16px; display: inline-block; margin-right: 8px;"></span>
                                        <span>Taxi</span>
                                    </div>
                                </div>
                            </div>
                            <div id="calendarAllKendaraan"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tambah Penggunaan Kendaraan Dinas Modal --}}
            <div class="modal fade" id="tambahDinasModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="tambahDinasModalLabel">Ajukan Penggunaan Kendaraan Dinas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="form-area modal-body">
                            <form method="POST" action="{{ route('pengajuan_dinas.store')}}" enctype="multipart/form-data" id="tambah_penggunaan_kendaraan_dinas">
                                @csrf
            
                                <!-- Input Fields -->
                                <div class="form-group">
                                    <label for="created_by">No Karyawan <span class="text-danger">*</span></label>
                                    {{-- <input type="text" class="form-control" id="created_by" name="created_by" value="{{ old('created_by') }}" placeholder="Masukan NRP Anda" required autocomplete="off"> --}}
                                    <select class="form-control selectize" id="created_by_dinas" name="created_by" required>
                                        <option value="" disabled selected>Pilih Karyawan</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="jenis_kendaraan">Jenis Kendaraan <span class="text-danger">*</span></label>
                                    <select class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" required autocomplete="off" required onchange="toggleJenisKendaraan()">
                                        <option value="" disabled selected>Pilih Jenis Kendaraan</option>
                                        <option value="1">KANTOR</option>
                                        <option value="2">PRIBADI</option>
                                        <option value="3">TAXI</option>
                                    </select>
                                </div>

                                <div class="form-group" id="kendaraan_kantor_group" style="display: none;">
                                    <label for="kendaraan_dinas_id">Pilih Kendaraan <span class="text-danger">*</span></label>
                                    <select class="form-control" id="kendaraan_dinas_id" name="kendaraan_dinas_id" required>
                                        <option value="" disabled selected>Pilih Kendaraan</option>
                                        <!-- Data kendaraan akan ditambahkan lewat JavaScript -->
                                    </select>
                                </div>

                                <div class="form-group" id="tabel_kendaraan_pribadi" style="display: none;">
                                    <label>Kendaraan <span class="text-danger">*</span></label>
                                    <table class="table table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>No Polisi</th>
                                                <th>Merk Kendaraan</th>
                                                <th>Kapasitas</th>
                                            </tr>
                                        </thead>
                                        <tbody id="kendaraanPribadiBody">
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="kendaraan[0][kendaraan_dinas_id]" class="kendaraan_dinas_id">
                                                    <select id="select_nopol_0" name="kendaraan[0][nomor_kendaraan]" class="custom-input select-nopol" data-index="0" required></select>
                                                </td>
                                                <td><input type="text" name="kendaraan[0][merk_kendaraan]" class="custom-input merk_kendaraan" required></td>
                                                <td><input type="number" name="kendaraan[0][kapasitas_kendaraan]" class="custom-input kapasitas_kendaraan input-kapasitas" min="1" required></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="form-group">
                                    <label for="tanggal_penggunaan">Tanggal Penggunaan <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="custom-input" 
                                        id="tanggal_penggunaan" 
                                        name="tanggal_penggunaan" 
                                        value="{{ old('tanggal_penggunaan') }}" 
                                        required 
                                        autocomplete="off"
                                        readonly
                                        onchange="toggleJenisKendaraan()"
                                    />
                                </div>
                                
                                <div class="form-group">
                                    <label for="tujuan_penggunaan">Rute Dinas <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-2">
                                        <input type="text" class="custom-input" name="tujuan_penggunaan_1" 
                                               value="{{ old('tujuan_penggunaan_1') }}" required autocomplete="off" placeholder="Rute Ke-1" required autocomplete="off">
                                        <input type="text" class="custom-input" name="tujuan_penggunaan_2" 
                                               value="{{ old('tujuan_penggunaan_2') }}" autocomplete="off" placeholder="Rute Ke-2" autocomplete="off">
                                        <input type="text" class="custom-input" name="tujuan_penggunaan_3" 
                                               value="{{ old('tujuan_penggunaan_3') }}" autocomplete="off" placeholder="Rute Ke-3" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group" id="waktu_pergi" hidden>
                                    <label for="waktu_pergi_input">Jam Keberangkatan <span class="text-danger">*</span></label>
                                    <input type="time" class="custom-input" id="waktu_pergi" name="waktu_pergi" placeholder="Pilih jam keberangkatan" autocomplete="off">
                                </div>


                                <div class="form-group" id="kendaraan_pribadi_group" style="display: none;">
                                    <label for="kilometer_awal">Kilometer Awal <span class="text-danger">*</span></label>
                                    <input type="number" class="custom-input" id="kilometer_awal" name="kilometer_awal" placeholder="Masukkan kilometer awal" autocomplete="off">
                                </div>

                                <div class="form-group" id="alasan_penggunaan">
                                    <label for="alasan_penggunaan">Keperluan <span class="text-danger">*</span></label>
                                    <textarea class="custom-input" id="alasan_penggunaan" name="alasan_penggunaan" placeholder="Masukkan keperluan penggunaan" autocomplete="off" rows="4" required></textarea>                                </div>
                                <!-- Peserta Dinas Table -->
                                <div class="form-group">
                                    <label>Peserta Dinas <span class="text-danger">*</span></label>
                                    <table id="pesertaTableTambah" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NRP</th>
                                                <th>Nama</th>
                                                <th>Departemen</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="nomor">1</td>
                                                <input type="hidden" name="peserta[0][nrp_karyawan]" id="hidden_nrp_peserta_0_regular" value="">
                                                <td><select name="peserta[0][nrp_karyawan]" class="nrp_karyawan selectize-nrp" required><option value="">Pilih NRP Karyawan</option></select></td>
                                                <td><input type="text" name="peserta[0][nama]" class="custom-input nama" placeholder="Nama" readonly></td>
                                                <td><input type="text" name="peserta[0][departemen]" class="custom-input departemen" placeholder="Departemen" readonly></td>

                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBoxPeserta(this)" disabled>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="tambahComboBoxPeserta()">
                                        <i class="fas fa-plus"></i> Tambah Peserta
                                    </button>
                                </div>
        
                                <!-- Submit Button -->
                                <div class="form-group d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                            @if(session('clear_local_storage'))
                            <script>
                                localStorage.removeItem('nrp_karyawan_list');
                            </script>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ikut Serta Penggunaan Kendaraan Dinas Modal --}}
            <div class="modal fade" id="ikutSertaDinasModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="editDataModalLabel">Ikut Serta Kendaraan Dinas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="form-area modal-body">
                            <!-- Bookings Table -->
                            <div class="mb-4">
                                <h6>Kendaraan</h6>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">No</th>
                                            <th style="text-align: center">No Polisi</th>
                                            <th style="text-align: center">Jenis Mobil</th>
                                            <th style="text-align: center">Jam Keberangkatan</th>
                                            <th style="text-align: center">Tanggal Penggunaan</th>
                                            <th style="text-align: center">Rute 1</th>
                                            <th style="text-align: center">Rute 2</th>
                                            <th style="text-align: center">Rute 3</th>
                                            <th style="text-align: center">Keperluan</th>
                                        </tr>
                                        
                                    </thead>
                                    <tbody id="bookingTableBody">
                                        <tr>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Peserta Dinas Table -->
                            <div class="form-group mt-3">
                                <h6>Peserta Dinas</h6>
                                <table id="pesertaIkut" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">No</th>
                                            <th style="text-align: center">No Surat Dinas</th>
                                            <th style="text-align: center">NRP</th>
                                            <th style="text-align: center">Nama</th>
                                            <th style="text-align: center">Departemen</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pesertaTableBody">
                                        <tr>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Close Button -->
                            <div class="form-group d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary mr-2" id="ikutSertaButton" data-toggle="modal" data-target="#tambahIkutSertaModal">Ikut Serta</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal untuk menambah peserta -->
            <div class="modal fade" id="tambahIkutSertaModal" tabindex="-1" role="dialog" aria-labelledby="tambahIkutSertaModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="tambahIkutSertaModalLabel">Tambah Ikut Serta Kendaraan Dinas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="form-area modal-body">
                            <form id="formTambahikutserta" method="POST" action="{{ route('ikutSerta_dinas.ikutSerta')}}" enctype="multipart/form-data">
                                @csrf
                                <!-- Hidden Inputs for Pre-filled Data -->
                                <input type="hidden" name="tujuan_penggunaan_1" id="ikut_tujuan_penggunaan_1">
                                <input type="hidden" name="tujuan_penggunaan_2" id="ikut_tujuan_penggunaan_2">
                                <input type="hidden" name="tujuan_penggunaan_3" id="ikut_tujuan_penggunaan_3">
                                <input type="hidden" name="waktu_pergi" id="ikut_waktu_pergi">
                                <input type="hidden" name="tanggal_penggunaan" id="ikut_tanggal_penggunaan">
                                <input type="hidden" name="jenis_kendaraan" id="ikut_jenis_kendaraan">
                                <input type="hidden" name="kendaraan_dinas_id" id="ikut_kendaraan_dinas_id">
                                <input type="hidden" name="alasan_penggunaan" id="ikut_alasan_penggunaan">

                                <!-- Input Fields -->
                                <div class="form-group">
                                    <label for="created_by">No Karyawan <span class="text-danger">*</span></label>
                                    <select class="form-control selectize" id="created_by_dinas" name="created_by" required>
                                        <option value="" disabled selected>Pilih Karyawan</option>
                                    </select>
                                </div>

                                <!-- Peserta Dinas Table -->
                                <div class="form-group">
                                    <label>Peserta Dinas <span class="text-danger">*</span></label>
                                    <table id="pesertaTableTambahPeserta" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NRP</th>
                                                <th>Nama</th>
                                                <th>Departemen</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="nomor">1</td>
                                                <input type="hidden" name="peserta[0][nrp_karyawan]" id="hidden_nrp_peserta_0_ikutserta" value="">
                                                <td><select name="peserta[0][nrp_karyawan]" class="nrp_karyawan selectize-nrp" required><option value="">Pilih NRP Karyawan</option></select></td>
                                                <td><input type="text" name="peserta[0][nama]" class="custom-input nama" placeholder="Nama" readonly></td>
                                                <td><input type="text" name="peserta[0][departemen]" class="custom-input departemen" placeholder="Departemen" readonly></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusIkutPeserta(this)" disabled>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="tambahPesertaIkutSerta()">
                                        <i class="fas fa-plus"></i> Tambah Peserta
                                    </button>
                                </div>

                                <!-- Form Actions -->
                                <div class="form-group d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary ml-2">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <!-- Grafis Section -->
        <div class="hero-section">
            <div class="text-container">
                <div class="text-center text-white">
                <div class="d-flex justify-content-center align-items-center mt-3" 
                    style="background: rgba(255, 255, 255); padding: 10px; border-radius: 8px; width: max-content; max-width: 100%; margin: auto;">
                    <img src="{{ asset('assets/img/Logo B YMI - 2017.png') }}" style="height: 80px; max-width: 100%; object-fit: contain;">
                </div>
                    <h2 class="h1 font-weight-bold mt-2">Digital Logistic Transport Permit</h2>
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div id="textCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <p class="lead">Memudahkan Pengurusan Administrasi</p>
                                </div>
                                <div class="carousel-item">
                                    <p class="lead">Mempermudah Pengeluaran Barang</p>
                                </div>
                                <div class="carousel-item">
                                    <p class="lead">Penggunaan Kendaraan Dinas</p>
                                </div>
                                <div class="carousel-item">
                                    <p class="lead">Meningkatkan Transparansi</p>
                                </div>
                                <div class="carousel-item">
                                    <p class="lead">Mengurangi Kesalahan Data</p>
                                </div>
                                <div class="carousel-item">
                                    <p class="lead">Notifikasi Email</p>
                                </div>
                                <div class="carousel-item">
                                    <p class="lead">Memantau Status Secara Real-Time</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="decorative-elements">
            <div class="circle-1"></div>
            <div class="circle-2"></div>
        </div>

        <section class="section position-relative pull-top">
            <div class="container">
                <div class="card shadow" >
                    <div class="card-header text-center"  style="border-top: 5px solid #5A6ACF;">
                        <h4>Pengajuan yang Siap untuk Dicetak</h4>
                    </div>
                    <div class="card-body p-5 bg-white">
                        <div class="row">
                            <!-- Card 1: Pengeluaran Barang -->
                            <div class="col-lg-6 col-md-6 mt-5 mt-md-0 text-center" id="modalPengajuanTrigger" style="cursor: pointer;">
                                <div class="card shadow card-hover">
                                    <div class="card-body">
                                        <i class="fas fa-box-open text-primary h1" style="cursor: pointer;"></i>
                                        <h3 class="mt-4 text-capitalize h5" style="cursor: pointer;">Cetak Pengeluaran Barang</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Card 2: Penggunaan Kendaraan Dinas -->
                            <div class="col-lg-6 col-md-6 mt-5 mt-md-0 text-center" id="modalSuratKendaraanTrigger" style="cursor: pointer;">
                                <div class="card shadow card-hover">
                                    <div class="card-body">
                                        <i class="fas fa-car-side text-primary h1" style="cursor: pointer;"></i>
                                        <h3 class="mt-4 text-capitalize h5" style="cursor: pointer;">Cetak Penggunaan Kendaraan Dinas</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal pengajuan pengeluaaran barang -->
        <div class="modal fade" id="modalPengajuan" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false">
            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalPengajuanLabel">Pengajuan Pengeluaran Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
        
                        <!-- Data Table -->
                        <table id="dataTable" class="table table-striped table-bordered nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Nomor Pengeluaran Barang</th>
                                    <th>Diajukan Oleh</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Asal Barang Keluar</th>
                                    <th>Tujuan Barang Keluar</th>
                                    <th>Jenis Kendaraan</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody id="detailBody">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail Barang Keluar -->
        <div class="modal fade" id="modalPengajuanBarangDetail" tabindex="-1" aria-labelledby="modalPengajuanBarangDetailLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalPengajuanBarangDetailLabel">Detail Pengajuan Pengeluaran Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <iframe hidden id="barangKeluarQrFrame" width="500" height="400" srcdoc="">
                            Browser Anda tidak mendukung iframe.
                        </iframe>
                        
                        <table id="barangKeluarTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi melalui JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="btnPrintQR" onclick="printIframePengeluaranBarang()">Cetak QR Code</button>
                    </div>
                </div>
            </div>
        </div>

         <!-- Modal penggunaan kendaraan dinas -->
        <div class="modal fade" id="modalSuratKendaraan" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false">
            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalSuratKendaraanLabel">Pengajuan Penggunaan Kendaraan Dinas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <table id="suratKendaraanTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Surat Dinas</th>
                                    <th>Diajukan Oleh</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Rute</th>
                                    <th>Jenis Kendaraan</th>
                                    <th>Tanggal Penggunaan</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody id="suratKendaraanBody"></tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail Peserta -->
        <div class="modal fade" id="modalPenggunaanKendaraanDinasDetail" tabindex="-1" aria-labelledby="modalPenggunaanKendaraanDinasDetailLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalPenggunaanKendaraanDinasDetailLabel">Detail Pengajuan Penggunaan Kendaraan Dinas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <iframe hidden id="pesertaDinasQrFrame" width="500" height="400" srcdoc="">
                            Browser Anda tidak mendukung iframe.
                        </iframe>
                        
                        <table id="pesertaTableDinas" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Surat Kendaraan Dinas</th>
                                    <th>NRP</th>
                                    <th>Nama</th>
                                    <th>Departemen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi melalui JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="btnPrintQR" onclick="printIframeSuratDinas()">Cetak QR Code</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        // Local storage keys for separation
        const STORAGE_KEY_TAMBAH = 'nrp_karyawan_list_tambah';
        const STORAGE_KEY_IKUTSERTA = 'nrp_karyawan_list_ikutserta';

        let counterPeserta = 1;
        let counterIkutserta = 1;
        let userCache = null; // Global cache for user data

        // Optimized user data loading with caching
        function loadUsers() {
            if (userCache) {
                return Promise.resolve(userCache);
            }

            return $.ajax({
                url: '/user/getAllUser',
                type: 'GET',
                dataType: 'json'
            }).then(function(data) {
                // Sort data by name for better UX
                data.sort((a, b) => a.name.localeCompare(b.name));
                userCache = data;
                return data;
            }).catch(function(xhr, status, error) {
                console.error('Gagal memuat data karyawan:', error);
                throw error;
            });
        }

        // Get user data by NRP from cache
        function getUserByNRP(nrp) {
            if (!userCache) return null;
            return userCache.find(user => user.nrp_karyawan === nrp);
        }

        // Initialize Selectize for NRP input
        function initializeSelectizeForNRP(element, onChangeCallback) {
            if (!userCache) {
                console.warn('User cache not loaded, cannot initialize Selectize');
                return;
            }

            // Destroy existing selectize if exists
            if (element.selectize) {
                element.selectize.destroy();
            }

            const userOptions = userCache.map(user => ({
                value: user.nrp_karyawan,
                text: `${user.nrp_karyawan} - ${user.name}`,
                name: user.name,
                departemen: user.departemen || ''
            }));

            $(element).selectize({
                options: userOptions,
                valueField: 'value',
                labelField: 'text',
                searchField: ['text'],
                sortField: 'text',
                placeholder: 'Pilih atau cari NRP Karyawan',
                create: false,
                maxItems: 1,
                allowEmptyOption: true,
                closeAfterSelect: true,
                // Optimized search scoring
                score: function(search) {
                    return function(item) {
                        const text = item.text.toLowerCase();
                        const searchLower = search.toLowerCase();
                        
                        // Exact match gets highest score
                        if (text === searchLower) return 2;
                        
                        // Starts with search term gets high score
                        if (text.startsWith(searchLower)) return 1.5;
                        
                        // Contains search term gets medium score
                        if (text.includes(searchLower)) return 1;
                        
                        return 0;
                    };
                },
                onChange: function(value) {
                    if (onChangeCallback && typeof onChangeCallback === 'function') {
                        onChangeCallback(value, this);
                    }
                }
            });
        }

        // Optimized function to set participant data
        function setParticipantData(row, nrp) {
            const userData = getUserByNRP(nrp);
            
            if (userData) {
                row.find('.nama').val(userData.name);
                row.find('.departemen').val(userData.departemen || '');
            } else {
                row.find('.nama').val('');
                row.find('.departemen').val('');
            }
            
            // Save to localStorage
            const tableId = row.closest('table').attr('id');
            const storageKey = getStorageKeyByTableId(tableId);
            saveToLocalStoragePeserta(tableId, storageKey);
        }

        // Get storage key based on table ID
        function getStorageKeyByTableId(tableId) {
            switch(tableId) {
                case 'pesertaTableTambah':
                    return STORAGE_KEY_TAMBAH;
                case 'pesertaTableTambahPeserta':
                    return STORAGE_KEY_IKUTSERTA;
                default:
                    return STORAGE_KEY_TAMBAH;
            }
        }

        // Save to local storage for specific table
        function saveToLocalStoragePeserta(tableId, storageKey) {
            const nrpInputs = $(`#${tableId} .nrp_karyawan`);
            const nrpList = Array.from(nrpInputs).map(input => $(input).val()).filter(val => val);
            try {
                localStorage.setItem(storageKey, JSON.stringify(nrpList));
            } catch (e) {
                console.error('Failed to save to localStorage:', e);
            }
        }

        // Load from local storage for specific table
        function loadFromLocalStoragePeserta(tableId, storageKey, addRowFn) {
            try {
                const storedList = localStorage.getItem(storageKey);
                if (storedList) {
                    const nrpList = JSON.parse(storedList);
                    const currentRows = $(`#${tableId} .nrp_karyawan`).length;

                    // Add rows if needed
                    while (currentRows < nrpList.length) {
                        addRowFn();
                    }

                    // Populate inputs with delay to ensure DOM is ready
                    setTimeout(() => {
                        $(`#${tableId} .nrp_karyawan`).each(function(idx) {
                            if (nrpList[idx] && this.selectize) {
                                this.selectize.setValue(nrpList[idx], true);
                                const row = $(this).closest('tr');
                                setParticipantData(row, nrpList[idx]);
                                if (idx === 0) {
                                    // Set nilai di hidden input untuk baris pertama
                                    const hiddenInputId = tableId === 'pesertaTableTambahPeserta' 
                                        ? '#hidden_nrp_peserta_0_ikutserta' 
                                        : '#hidden_nrp_peserta_0_regular';
                                    $(hiddenInputId).val(nrpList[idx]);
                                    this.selectize.disable();
                                }
                            }
                        });
                        // Nonaktifkan tombol hapus untuk baris pertama
                        $(`#${tableId} tbody tr:first .btn-hapus-peserta`).prop('disabled', true);
                    }, 100);
                }
            } catch (e) {
                console.error('Failed to load from localStorage:', e);
            }
        }

        // Clear local storage for specific key
        function clearLocalStorage(storageKey) {
            try {
                localStorage.removeItem(storageKey);
            } catch (e) {
                console.error('Failed to clear localStorage:', e);
            }
        }

        // Update participant numbers for a table
        function updateNomorPeserta(tableId) {
            $(`#${tableId} .nomor`).each(function(index) {
                $(this).text(index + 1);
                const row = $(this).closest('tr');
                row.find('.nrp_karyawan').attr('name', `peserta[${index}][nrp_karyawan]`);
                row.find('.nama').attr('name', `peserta[${index}][nama]`);
                row.find('.departemen').attr('name', `peserta[${index}][departemen]`);
            });
        }

        // Enhanced tambahComboBoxPeserta with Selectize
        function tambahComboBoxPeserta() {
            const container = document.querySelector('#pesertaTableTambah tbody');
            const rows = container.querySelectorAll('tr');

            if (!selectedVehicleCapacity) {
                const kapasitasField = $(`input[name="kendaraan[0][kapasitas_kendaraan]"]`);
                if (kapasitasField.val() === '' || isNaN(parseInt(kapasitasField.val()))) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Kendaraan Terlebih Dahulu',
                        text: 'Silakan pilih kendaraan.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#0d6efd'
                    });
                    return;
                }
                selectedVehicleCapacity = parseInt(kapasitasField.val()) - 1;
            }

            if (rows.length >= selectedVehicleCapacity) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kapasitas Penuh',
                    text: `Kapasitas kendaraan adalah ${selectedVehicleCapacity}`,
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const newRow = document.createElement('tr');
            const isFirstRow = rows.length === 0;
            const nrpValue = isFirstRow ? $('select[name="created_by"]').val() : '';
            newRow.innerHTML = `
                <td class="nomor">${++counterPeserta}</td>
                <td>
                    <select ${isFirstRow ? '' : `name="peserta[${counterPeserta - 1}][nrp_karyawan]"`} 
                            class="nrp_karyawan selectize-nrp" 
                            required ${isFirstRow ? 'readonly' : ''}>
                        <option value="">Pilih NRP Karyawan</option>
                        ${nrpValue ? `<option value="${nrpValue}" selected>${nrpValue}</option>` : ''}
                    </select>
                </td>
                <td><input type="text" name="peserta[${counterPeserta - 1}][nama]" class="custom-input nama" placeholder="Nama" readonly></td>
                <td><input type="text" name="peserta[${counterPeserta - 1}][departemen]" class="custom-input departemen" placeholder="Departemen" readonly></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm btn-hapus-peserta" 
                            onclick="hapusComboBoxPeserta(this)" ${isFirstRow ? 'disabled' : ''}>
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            container.appendChild(newRow);
            
            // Initialize Selectize for the new NRP input
            const newNrpSelect = newRow.querySelector('.nrp_karyawan');
            initializeSelectizeForNRP(newNrpSelect, function(value, selectizeInstance) {
                const row = $(selectizeInstance.$input).closest('tr');
                setParticipantData(row, value);
            });

            // Jika baris pertama, set nilai di hidden input, Selectize, dan panggil setParticipantData
            if (isFirstRow && nrpValue) {
                $('#hidden_nrp_peserta_0_regular').val(nrpValue);
                newNrpSelect.selectize.setValue(nrpValue, true);
                setParticipantData(newRow, nrpValue);
                newNrpSelect.selectize.disable();
            }
            
            updateNomorPeserta('pesertaTableTambah');
            saveToLocalStoragePeserta('pesertaTableTambah', STORAGE_KEY_TAMBAH);
        }

        // Enhanced tambahPesertaIkutSerta with Selectize
        function tambahPesertaIkutSerta() {
            const tbody = document.querySelector('#pesertaTableTambahPeserta tbody');
            const rows = tbody.querySelectorAll('tr');

            if (!selectedVehicleCapacity || selectedVehicleCapacity <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kapasitas Kendaraan Tidak Diketahui',
                    text: 'Silakan pilih kendaraan terlebih dahulu.',
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (rows.length >= selectedVehicleCapacity) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kapasitas Penuh',
                    text: `Kapasitas kendaraan adalah ${selectedVehicleCapacity}`,
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const newRow = document.createElement('tr');
            const isFirstRow = rows.length === 0;
            const nrpValue = isFirstRow ? $('select[name="created_by"]').val() : '';
            newRow.innerHTML = `
                <td class="nomor">${++counterIkutserta}</td>
                <td>
                    <select ${isFirstRow ? '' : `name="peserta[${counterIkutserta - 1}][nrp_karyawan]"`} 
                            class=" nrp_karyawan selectize-nrp" 
                            required ${isFirstRow ? 'readonly' : ''}>
                        <option value="">Pilih NRP Karyawan</option>
                        ${nrpValue ? `<option value="${nrpValue}" selected>${nrpValue}</option>` : ''}
                    </select>
                </td>
                <td><input type="text" name="peserta[${counterIkutserta - 1}][nama]" class="custom-input nama" placeholder="Nama" readonly></td>
                <td><input type="text" name="peserta[${counterIkutserta - 1}][departemen]" class="custom-input departemen" placeholder="Departemen" readonly></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm btn-hapus-peserta" 
                            onclick="hapusIkutPeserta(this)" ${isFirstRow ? 'disabled' : ''}>
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(newRow);
            
            // Initialize Selectize for the new NRP input
            const newNrpSelect = newRow.querySelector('.nrp_karyawan');
            initializeSelectizeForNRP(newNrpSelect, function(value, selectizeInstance) {
                const row = $(selectizeInstance.$input).closest('tr');
                setParticipantData(row, value);
            });

            // Jika baris pertama, set nilai di hidden input, Selectize, dan panggil setParticipantData
            if (isFirstRow && nrpValue) {
                $('#hidden_nrp_peserta_0_ikutserta').val(nrpValue);
                newNrpSelect.selectize.setValue(nrpValue, true);
                setParticipantData(newRow, nrpValue);
                newNrpSelect.selectize.disable();
            }
            
            updateNomorPeserta('pesertaTableTambahPeserta');
            saveToLocalStoragePeserta('pesertaTableTambahPeserta', STORAGE_KEY_IKUTSERTA);
        }

        //Web Scrapper Validation
        function formatDateLocal(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // bulan 0-based
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        $('#tanggal_penggunaan').on('change', function() {
            const inputDate = new Date($(this).val());
            const today = new Date();
            today.setHours(0,0,0,0);
            inputDate.setHours(0,0,0,0);

            if (inputDate < today) {
                $(this).val(formatDateLocal(today));

                Swal.fire({
                    icon: 'warning',
                    title: 'Tanggal Tidak Valid',
                    text: 'Anda tidak dapat melakukan pemesanan untuk tanggal hari ini atau yang sudah lewat.',
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'OK'
                });
            }
        });


        // Remove participant row for tambahDinasModal
        function hapusComboBoxPeserta(button) {
            const tbody = document.querySelector('#pesertaTableTambah tbody');
            const row = button.closest('tr');
            const rows = tbody.querySelectorAll('tr');

            if (rows.length > 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Apakah Anda yakin?',
                    text: 'Baris ini akan dihapus.',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    confirmButtonColor: '#dc3545', 
                    cancelButtonText: 'Tidak',
                    cancelButtonColor: '#6c757d',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Destroy selectize before removing row
                        const selectizeInput = row.querySelector('.nrp_karyawan');
                        if (selectizeInput && selectizeInput.selectize) {
                            selectizeInput.selectize.destroy();
                        }
                        
                        row.remove();
                        counterPeserta--;
                        updateNomorPeserta('pesertaTableTambah');
                        saveToLocalStoragePeserta('pesertaTableTambah', STORAGE_KEY_TAMBAH);
                    }
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Tidak bisa menghapus baris terakhir.',
                    text: 'Harap tambahkan baris baru jika perlu.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d6efd'
                });
            }
        }

        // Remove participant row for ikutSertaDinasModal
        function hapusIkutPeserta(button) {
            const tbody = document.querySelector('#pesertaTableTambahPeserta tbody');
            const row = button.closest('tr');
            const rows = tbody.querySelectorAll('tr');

            if (rows.length > 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Apakah Anda yakin?',
                    text: 'Baris ini akan dihapus.',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    confirmButtonColor: '#dc3545', 
                    cancelButtonText: 'Tidak',
                    cancelButtonColor: '#6c757d',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Destroy selectize before removing row
                        const selectizeInput = row.querySelector('.nrp_karyawan');
                        if (selectizeInput && selectizeInput.selectize) {
                            selectizeInput.selectize.destroy();
                        }
                        
                        row.remove();
                        counterIkutserta--;
                        updateNomorPeserta('pesertaTableTambahPeserta');
                        saveToLocalStoragePeserta('pesertaTableTambahPeserta', STORAGE_KEY_IKUTSERTA);
                    }
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Tidak bisa menghapus baris terakhir.',
                    text: 'Harap tambahkan baris baru jika perlu.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d6efd'
                });
            }
        }

        // Document ready functions
        $(document).ready(function () {
            // Load user data first
            loadUsers().then(function(userData) {
                console.log('User data loaded successfully:', userData.length, 'users');
                
                // Initialize existing selectize dropdowns
                populateMainDropdowns(userData);
                
                // Initialize existing NRP selectize inputs if any
                $('.selectize-nrp').each(function() {
                    initializeSelectizeForNRP(this, function(value, selectizeInstance) {
                        const row = $(selectizeInstance.$input).closest('tr');
                        setParticipantData(row, value);
                    });
                });
                
                // Load stored data from localStorage
                loadFromLocalStoragePeserta('pesertaTableTambah', STORAGE_KEY_TAMBAH, tambahComboBoxPeserta);
                loadFromLocalStoragePeserta('pesertaTableTambahPeserta', STORAGE_KEY_IKUTSERTA, tambahPesertaIkutSerta);
                
            }).catch(function(error) {
                console.error('Failed to load user data:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memuat Data',
                    text: 'Tidak dapat memuat data karyawan. Silakan refresh halaman.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d6efd'
                });
            });

            // Function to populate main dropdowns (created_by_dinas, etc.)
            function populateMainDropdowns(data) {
                const userOptions = data.map(user => ({
                    value: user.nrp_karyawan,
                    text: `${user.nrp_karyawan} - ${user.name}`,
                    name: user.name,
                    departemen: user.departemen || ''
                }));

                const optionsHtml = ['<option value="" disabled selected>Pilih Karyawan</option>']
                    .concat(data.map(user => `<option value="${user.nrp_karyawan}">${user.nrp_karyawan} - ${user.name}</option>`))
                    .join('');

                $('#created_by_barang, #created_by_dinas').html(optionsHtml);

                // Destroy existing Selectize instances
                $('.selectize:not(.selectize-nrp)').each(function () {
                    if (this.selectize) {
                        this.selectize.destroy();
                    }
                });

                // Initialize main selectize dropdowns
                $('.selectize:not(.selectize-nrp)').selectize({
                    options: userOptions,
                    valueField: 'value',
                    labelField: 'text',
                    searchField: ['text'],
                    sortField: 'text',
                    placeholder: 'Pilih atau cari Karyawan',
                    score: function (search) {
                        return function (item) {
                            let text = item.text.toLowerCase();
                            search = search.toLowerCase();
                            return text.includes(search) ? 1 : 0;
                        };
                    },
                    onChange: function(value) {
                        if (this.$input.attr('id') === 'created_by_dinas') {
                            const activeModal = determineActiveModal();
                            if (value) {
                                $('#hidden_nrp_peserta_0_regular').val(value);
                                $('#hidden_nrp_peserta_0_ikutserta').val(value);
                                setFirstParticipant(value, activeModal);
                            } else {
                                $('#hidden_nrp_peserta_0_regular').val('');
                                $('#hidden_nrp_peserta_0_ikutserta').val('');
                                const tables = ['pesertaTableTambah', 'pesertaTableTambahPeserta'];
                                tables.forEach(tableId => {
                                    const firstRow = $(`#${tableId} tbody tr:first`);
                                    if (firstRow.length) {
                                        const nrpInput = firstRow.find('.nrp_karyawan')[0];
                                        if (nrpInput && nrpInput.selectize) {
                                            nrpInput.selectize.setValue('', true);
                                            firstRow.find('.nama').val('');
                                            firstRow.find('.departemen').val('');
                                            nrpInput.selectize.disable();
                                        }
                                    }
                                });
                            }
                        }
                    }
                });
            }

            // Function to determine which modal is currently active
            function determineActiveModal() {
                if ($('#tambahIkutSertaModal').hasClass('show') || $('#tambahIkutSertaModal').is(':visible')) {
                    return 'ikutserta';
                }
                return 'regular';
            }

            // Function to set first participant data from created_by_dinas selection
            function setFirstParticipant(nrpValue, modalType = 'regular') {
                if (!nrpValue) return;

                let firstRow, tableSelector, hiddenInputId;
                
                if (modalType === 'ikutserta') {
                    tableSelector = '#pesertaTableTambahPeserta tbody tr:first';
                    hiddenInputId = '#hidden_nrp_peserta_0_ikutserta';
                } else {
                    tableSelector = '#pesertaTableTambah tbody tr:first';
                    hiddenInputId = '#hidden_nrp_peserta_0_regular';
                }
                
                firstRow = $(tableSelector);
                
                if (firstRow.length === 0) {
                    console.warn('First participant row not found for modal type:', modalType);
                    return;
                }

                // Set nilai di hidden input
                $(hiddenInputId).val(nrpValue);
                
                const nrpInput = firstRow.find('.nrp_karyawan')[0];
                
                if (nrpInput && nrpInput.selectize) {
                    // Set nilai di Selectize untuk UI
                    nrpInput.selectize.setValue(nrpValue, true);
                    // Nonaktifkan Selectize untuk mencegah perubahan
                    nrpInput.selectize.disable();
                    // Isi nama dan departemen
                    setParticipantData(firstRow, nrpValue);
                } else {
                    console.warn('Selectize not initialized for NRP input in modal type:', modalType);
                }
                
                console.log(`Set first participant NRP for ${modalType} modal:`, nrpValue);
            }

            // Modal event handlers
            $('#tambahIkutSertaModal').on('shown.bs.modal', function () {
                const selectizeInstance = $('#created_by_dinas')[0].selectize;
                if (selectizeInstance) {
                    selectizeInstance.clear();
                }
            });

            $('[data-target="#tambahModal"], [data-toggle="modal"][data-target*="tambah"]').on('click', function() {
                setTimeout(function() {
                    const selectizeInstance = $('#created_by_dinas')[0].selectize;
                    if (selectizeInstance) {
                        selectizeInstance.clear();
                    }
                }, 100);
            });

            // Clear local storage on form submission
            $('#tambah_penggunaan_kendaraan_dinas').on('submit', function() {
                clearLocalStorage(STORAGE_KEY_TAMBAH);
            });

            $('#formTambahikutserta').on('submit', function() {
                clearLocalStorage(STORAGE_KEY_IKUTSERTA);
            });

            // Legacy support for created_by sync
            $('#created_by').on('input', function() {
                const nrp = $(this).val();
                const firstParticipantNrp = $("input[name='peserta[0][nrp_karyawan]']")[0];
                if (firstParticipantNrp && firstParticipantNrp.selectize) {
                    firstParticipantNrp.selectize.setValue(nrp);
                }
            });
        });

        function printIframePengeluaranBarang() {
            var iframe = document.getElementById('barangKeluarQrFrame');
            iframe.contentWindow.print(); // Cetak isi dalam iframe
        }

        function printIframeSuratDinas() {
            var iframe = document.getElementById('pesertaDinasQrFrame');
            iframe.contentWindow.print(); // Cetak isi dalam iframe
        }

        function saveToLocalStorage() {
            const rows = document.querySelectorAll('#barangTableTambah tbody tr');
            const data = Array.from(rows).map(row => ({
                barang_id: row.querySelector('[name="barang_ids[]"]').value,
                jumlah: row.querySelector('[name="jumlah[]"]').value,
                satuan: row.querySelector('[name="satuan[]"]').value,
                keterangan: row.querySelector('[name="keterangan[]"]').value
            }));
            localStorage.setItem('barang_keluar_data', JSON.stringify(data));
        }

        let counter = 1;

        function tambahComboBox() {
            const tbody = document.querySelector('#barangTableTambah tbody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td class="nomor">${++counter}</td>
                <td><input type="text" name="barang_ids[]" class="custom-input" placeholder="Nama Barang" required autocomplete="off"></td>
                <td><input type="text" name="jumlah[]" class="custom-input jumlah-input" placeholder="Jumlah" required autocomplete="off"></td>
                <td>
                    <select name="satuan[]" class="custom-input" required>
                        <option value="" disabled selected>Pilih Satuan</option>
                        <option value="unit">Unit</option>
                        <option value="pcs">PCS</option>
                        <option value="kg">KG</option>
                        <option value="jumbo bag">JUMBO BAG</option>
                        <option value="drum">DRUM</option>
                    </select>
                </td>
                <td><input type="text" name="keterangan[]" class="custom-input" placeholder="Keterangan" autocomplete="off"></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBox(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(newRow);
            updateNomor();
            saveToLocalStorage(); 
        }

        function hapusComboBox(button) {
            const tbody = document.querySelector('#barangTableTambah tbody');
            const row = button.closest('tr');
            const rows = tbody.querySelectorAll('tr');

            if (rows.length > 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Apakah Anda yakin?',
                    text: 'Baris ini akan dihapus.',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    confirmButtonColor: '#dc3545', 
                    cancelButtonText: 'Tidak',
                    cancelButtonColor: '#6c757d',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        row.remove();
                        updateNomor();
                        saveToLocalStorage(); // simpan setelah hapus
                    }
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Tidak bisa menghapus baris terakhir.',
                    text: 'Harap tambahkan baris baru jika perlu.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d6efd'
                });
            }
        }

        function updateNomor() {
            const rows = document.querySelectorAll('#barangTableTambah .nomor');
            rows.forEach((cell, index) => {
                cell.textContent = index + 1;
            });
        }

        // Auto simpan ketika input berubah
        document.addEventListener('input', function (event) {
            if (event.target.closest('#barangTableTambah')) {
                saveToLocalStorage();
            }
        });

        function loadBarangDataFromLocalStorage() {
            const stored = localStorage.getItem('barang_keluar_data');
            if (!stored) return;

            const data = JSON.parse(stored);
            const tbody = document.querySelector('#barangTableTambah tbody');
            tbody.innerHTML = ''; // kosongkan isi sebelumnya
            counter = 0;

            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="nomor">${++counter}</td>
                    <td><input type="text" name="barang_ids[]" class="custom-input" value="${item.barang_id}" placeholder="Nama Barang" required autocomplete="off"></td>
                    <td><input type="text" name="jumlah[]" class="custom-input jumlah-input" value="${item.jumlah}" placeholder="Jumlah" required autocomplete="off"></td>
                    <td>
                        <select name="satuan[]" class="custom-input" required>
                            <option value="" disabled ${item.satuan === '' ? 'selected' : ''}>Pilih Satuan</option>
                            <option value="unit" ${item.satuan === 'unit' ? 'selected' : ''}>Unit</option>
                            <option value="pcs" ${item.satuan === 'pcs' ? 'selected' : ''}>PCS</option>
                            <option value="kg" ${item.satuan === 'kg' ? 'selected' : ''}>KG</option>
                            <option value="jumbo bag" ${item.satuan === 'jumbo bag' ? 'selected' : ''}>JUMBO BAG</option>
                            <option value="drum" ${item.satuan === 'drum' ? 'selected' : ''}>DRUM</option>
                        </select>
                    </td>
                    <td><input type="text" name="keterangan[]" class="custom-input" value="${item.keterangan}" placeholder="Keterangan" autocomplete="off"></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBox(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });

            updateNomor();
        }

        // Load saat modal dibuka
        $('#tambahDataModal').on('shown.bs.modal', function () {
            loadBarangDataFromLocalStorage();
        });
        
        let globalCalendar;
        let currentEventCapacity = 0;
        const $ikutSertaButton = $('#ikutSertaButton');
        const $tambahIkutSertaModal = $('#tambahIkutSertaModal');
        const $pesertaTableBody = $('#pesertaTableTambahPeserta tbody');

        $('#calendarModal').on('show.bs.modal', function() {
            $.get(`/kendaraan/booking-dates-all`, function(data) {
                console.log('Fetching booking-dates-all at:', new Date().toISOString());
                const events = data
                    .filter(item => item.status !== 'Expired' || item.status === 'Level 0')
                    .map(item => {
                        let badgeText = '';
                        let color = '';
                        switch (item.jenis_kendaraan) {
                            case 1:
                                color = '#28a745';
                                break;
                            case 2:
                                color = '#007bff';
                                break;
                            case 3:
                                color = '#ffc107';
                                break;
                            default:
                                badgeText = '';
                        }

                        return {
                            id: item.kendaraan_dinas_id,
                            title: `<strong>${item.nomor_kendaraan}</strong><br>${item.merk_kendaraan} (${item.kapasitas_tersedia > 0 ? 'Sisa: ' + item.kapasitas_tersedia : 'Penuh'})`,
                            start: item.tanggal_penggunaan,
                            allDay: true,
                            backgroundColor: color,
                            borderColor: color,
                            textColor: '#ffffff',
                            extendedProps: {
                                merk: item.merk_kendaraan,
                                nopol: item.nomor_kendaraan,
                                tanggal: item.tanggal_penggunaan,
                                surat_ids: item.surat_ids.split(','),
                                status: item.status,
                                jenis: item.jenis_kendaraan,
                                kapasitas_tersedia: item.kapasitas_tersedia,
                                kendaraan_dinas_id: item.kendaraan_dinas_id
                            }
                        };
                    });

                if (globalCalendar) globalCalendar.destroy();

                const calendarEl = document.getElementById('calendarAllKendaraan');
                globalCalendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 450,
                    locale: 'id',
                    events: events,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,listMonth'
                    },
                    buttonText: {
                        today: 'Hari Ini',
                        month: 'Bulan',
                        list: 'Daftar Data',
                    },
                    dayCellDidMount: function(info) {
                        const cellDate = new Date(info.date);
                        const today = new Date();
                        
                        // Set waktu ke 00:00:00 untuk perbandingan yang akurat
                        cellDate.setHours(0, 0, 0, 0);
                        today.setHours(0, 0, 0, 0);
                        
                        const cell = info.el;
                        
                        if (cellDate.getTime() < today.getTime()) {
                            // Tanggal yang sudah lewat - warna abu-abu
                            cell.style.backgroundColor = '#f8f9fa';
                            cell.style.color = '#6c757d';
                            cell.style.opacity = '0.6';
                        } else if (cellDate.getTime() === today.getTime()) {
                            // Tanggal hari ini - warna biru
                            cell.style.backgroundColor = '#e3f2fd';
                            cell.style.color = '#1976d2';
                            cell.style.fontWeight = 'bold';
                            cell.style.border = '2px solid #1976d2';
                        }
                    },

                    eventDidMount: function(info) {
                        const kapasitas = info.event.extendedProps.kapasitas_tersedia || 0;
                        const bgColor = info.event.backgroundColor;

                        // Tambahkan cursor pointer
                        $(info.el).css('cursor', 'pointer');

                        // Cek apakah event di tanggal yang sudah lewat
                        const eventDate = new Date(info.event.start);
                        const today = new Date();
                        eventDate.setHours(0, 0, 0, 0);
                        today.setHours(0, 0, 0, 0);
                        
                        if (eventDate.getTime() < today.getTime()) {
                            // Event di tanggal yang sudah lewat - buat lebih transparan
                            $(info.el).css({
                                'opacity': '0.5',
                                'filter': 'grayscale(50%)'
                            });
                        }

                    },
                    eventContent: function(arg) {
                        return { html: `<div class="fc-custom-event">${arg.event.title}</div>` };
                    },
                    eventClick: function(info) {
                        if (globalCalendar.isProcessing) return;
                        globalCalendar.isProcessing = true;

                        const event = info.event;
                        globalCalendar.currentEventId = event.id;
                        const suratIds = event.extendedProps.surat_ids;
                        const jenisKendaraan = event.extendedProps.jenis;
                        const noPolisi = event.extendedProps.nopol;
                        const kendaraanDinasId = event.extendedProps.kendaraan_dinas_id;
                        currentEventCapacity = event.extendedProps.kapasitas_tersedia || 0;
                        selectedVehicleCapacity = currentEventCapacity;
                        console.log('Selected Vehicle Capacity eventClick:', currentEventCapacity);
                        console.log('Event ID eventClick:', globalCalendar.currentEventId);

                        const eventDate = new Date(event.start);
                        const today = new Date();
                        today.setHours(0, 0, 0, 0);
                        eventDate.setHours(0, 0, 0, 0);

                        const ikutSertaButton = $ikutSertaButton;
                        if (eventDate < today || currentEventCapacity <= 0) {
                            ikutSertaButton.hide();
                        } else {
                            ikutSertaButton.show();
                        }

                        $('#eventTitle').text(event.title);
                        $('#eventDate').text(event.startStr);

                        $.ajax({
                            url: '/pengajuan/infoSuratKendaraanDinasNonAuth',
                            type: 'POST',
                            data: {
                                surat_kendaraan_dinas_id: suratIds.join(','),
                                kendaraan_dinas_id: kendaraanDinasId,
                                '_token': '{{ csrf_token() }}'
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response && Array.isArray(response)) {
                                    const jenisMapping = {
                                        1: 'KANTOR',
                                        2: 'PRIBADI',
                                        3: 'TAXI'
                                    };

                                    const filteredBookings = response.filter(booking => 
                                        booking.kendaraan_dinas_id == kendaraanDinasId
                                    );

                                    const bookingTableBody = $('#bookingTableBody');
                                    bookingTableBody.empty();
                                    const uniqueBookings = filteredBookings.reduce((acc, booking) => {
                                        acc.waktuPergi = booking.waktu_pergi || acc.waktuPergi || '-';
                                        acc.tanggal = booking.tanggal_penggunaan || acc.tanggal || '-';
                                        acc.jenis = jenisMapping[booking.jenis_kendaraan] || acc.jenis || 'TIDAK DIKETAHUI';
                                        acc.tujuan1 = acc.tujuan1 || booking.tujuan_penggunaan_1 || '-';
                                        acc.tujuan2 = acc.tujuan2 || booking.tujuan_penggunaan_2 || '-';
                                        acc.tujuan3 = acc.tujuan3 || booking.tujuan_penggunaan_3 || '-';
                                        acc.alasan_penggunaan = acc.alasan_penggunaan || booking.alasan_penggunaan || '-';
                                        return acc;
                                    }, {});
                                    bookingTableBody.append(`
                                        <tr>
                                            <td style="text-align: center">1</td>
                                            <td>${noPolisi || '-'}</td>
                                            <td>${uniqueBookings.jenis}</td>
                                            <td style="text-align: right">${uniqueBookings.waktuPergi}</td>
                                            <td style="text-align: right">${uniqueBookings.tanggal}</td>
                                            <td>${uniqueBookings.tujuan1}</td>
                                            <td>${uniqueBookings.tujuan2}</td>
                                            <td>${uniqueBookings.tujuan3}</td>
                                            <td>${uniqueBookings.alasan_penggunaan}</td>
                                        </tr>
                                    `);

                                    const pesertaTableBody = $('#pesertaTableBody');
                                    pesertaTableBody.empty();
                                    let participantIndex = 1;
                                    filteredBookings.forEach(booking => {
                                        if (booking.userDinas && Array.isArray(booking.userDinas)) {
                                            booking.userDinas.forEach(user => {
                                                pesertaTableBody.append(`
                                                    <tr>
                                                        <td style="text-align: center">${participantIndex}</td>
                                                        <td>${booking.surat_kendaraan_dinas_id || '-'}</td>
                                                        <td>${user.nrp_karyawan || '-'}</td>
                                                        <td>${user.name || '-'}</td>
                                                        <td>${user.departemen || '-'}</td>
                                                    </tr>
                                                `);
                                                participantIndex++;
                                            });
                                        }
                                    });

                                    $('#ikutSertaDinasModal').modal('show');
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal Memuat Data',
                                    text: 'Gagal mengambil data surat kendaraan dinas. Silakan coba lagi.',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#0d6efd'
                                });
                            },
                            complete: function() {
                                globalCalendar.isProcessing = false;
                            }
                        });
                    },
                    dateClick: function(info) {
                        const clickedDate = new Date(info.dateStr);
                        const today = new Date();
                        today.setHours(0, 0, 0, 0);
                        clickedDate.setHours(0, 0, 0, 0);

                        if (clickedDate < today) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Tanggal Tidak Valid',
                                text: 'Anda tidak dapat melakukan pemesanan untuk tanggal hari ini atau yang sudah lewat.',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#0d6efd'
                            });
                            return;
                        }

                        // Atur value tanggal
                        $('#tanggal_penggunaan').val(info.dateStr);
                        lastFetchedDate = null;

                        // Tampilkan modal
                        $('#tambahDinasModal').modal('show');

                        // Filter opsi kendaraan jika tanggal == hari ini
                        const kantorOption = document.querySelector('#jenis_kendaraan option[value="1"]');
                        if (clickedDate.getTime() === today.getTime()) {
                            if (kantorOption) kantorOption.style.display = 'none';
                        } else {
                            if (kantorOption) kantorOption.style.display = 'block';
                        }

                        // Jalankan toggle jika diperlukan
                        if (document.getElementById("jenis_kendaraan").value) {
                            toggleJenisKendaraan();
                        }
                    }
                });

                globalCalendar.render();

                const currentDate = globalCalendar.getDate();
                $('#monthPickerGlobal').val(currentDate.toISOString().slice(0, 7));

                $('#monthPickerGlobal').off('change').on('change', function() {
                    const selected = this.value;
                    if (selected) {
                        const newDate = selected + '-01';
                        globalCalendar.gotoDate(newDate);
                        if ($('#tambahDinasModal').hasClass('show')) {
                            $('#tanggal_penggunaan').val(newDate);
                            lastFetchedDate = null;
                            if (document.getElementById("jenis_kendaraan").value) {
                                toggleJenisKendaraan();
                            }
                        }
                    }
                });
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memuat Kalender',
                    text: 'Gagal mengambil data pemesanan kendaraan. Silakan coba lagi.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d6efd'
                });
            });
        });

        let selectedVehicleCapacity = 0;
        let kendaraanList = [];
        let lastFetchedDate = null;
        let lastFetchedJenis = null;

        function toggleJenisKendaraan() {
            const jenisKendaraan = document.getElementById("jenis_kendaraan").value;
            const tanggalPenggunaan = document.getElementById("tanggal_penggunaan").value;
            const kendaraanGroup = document.getElementById("kendaraan_pribadi_group");
            const tabelKendaraan = document.getElementById("tabel_kendaraan_pribadi");
            const kendaraanKantorGroup = document.getElementById("kendaraan_kantor_group");
            const kilometerAwal = document.getElementById("kilometer_awal");
            const kendaraanBody = document.getElementById("kendaraanPribadiBody");
            const kendaraanSelect = document.getElementById("kendaraan_dinas_id");
            const tujuan1 = document.querySelector('input[name="tujuan_penggunaan_1"]');
            const tujuan2 = document.querySelector('input[name="tujuan_penggunaan_2"]');
            const tujuan3 = document.querySelector('input[name="tujuan_penggunaan_3"]');

            // Reset UI elements
            kendaraanGroup.style.display = "none";
            tabelKendaraan.style.display = "none";
            kendaraanKantorGroup.style.display = "none";
            kilometerAwal.removeAttribute("required");
            kilometerAwal.value = "";
            kendaraanBody.innerHTML = "";
            kendaraanSelect.innerHTML = "";
            selectedVehicleCapacity = null;

            // Reset destination fields
            tujuan1.value = "";
            tujuan2.value = "";
            tujuan3.value = "";
            tujuan1.removeAttribute("readonly");
            tujuan2.removeAttribute("readonly");
            tujuan3.removeAttribute("readonly");

            // Destroy existing Selectize instance if it exists
            if (kendaraanSelect.selectize) {
                kendaraanSelect.selectize.destroy();
            }

            // Enable kendaraan_dinas_id
            kendaraanSelect.disabled = false;
            kendaraanSelect.removeAttribute("disabled");

            if (!tanggalPenggunaan || !jenisKendaraan) {
                if (!tanggalPenggunaan) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tanggal Penggunaan Belum Dipilih',
                        text: 'Silakan pilih tanggal penggunaan terlebih dahulu.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#0d6efd'
                    });
                } else if (!jenisKendaraan) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Jenis Kendaraan Belum Dipilih',
                        text: 'Silakan pilih jenis kendaraan terlebih dahulu.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#0d6efd'
                    });
                }
                return;
            }

            // Avoid redundant API calls
            if (lastFetchedDate === tanggalPenggunaan && lastFetchedJenis === jenisKendaraan) {
                return;
            }

            // Update last fetched values
            lastFetchedDate = tanggalPenggunaan;
            lastFetchedJenis = jenisKendaraan;

            // Fetch vehicle data
            fetch(`/kendaraan/get-by-jenis?jenis_kendaraan=${jenisKendaraan}&tanggal_penggunaan=${tanggalPenggunaan}`)
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Gagal mengambil data kendaraan');
                    }
                    return res.json();
                })
                .then(data => {
                    kendaraanList = data;

                    if (jenisKendaraan === "2" || jenisKendaraan === "3") {
                        const isPribadi = jenisKendaraan === "2";
                        if (isPribadi) {
                            kendaraanGroup.style.display = "block";
                            kilometerAwal.setAttribute("required", "required");
                            kendaraanSelect.removeAttribute("required");
                            kendaraanSelect.disabled = true;
                        } else {
                            kilometerAwal.removeAttribute("required");
                            kendaraanSelect.removeAttribute("required");
                            kendaraanSelect.disabled = true;
                        }

                        tabelKendaraan.style.display = "block";

                        kendaraanBody.innerHTML = `
                            <tr>
                                <td>
                                    <input type="hidden" name="kendaraan[0][kendaraan_dinas_id]" class="kendaraan_dinas_id">
                                    <select id="select_nopol_0" name="kendaraan[0][nomor_kendaraan]" class="form-control select-nopol" data-index="0" required></select>
                                </td>
                                <td><input type="text" name="kendaraan[0][merk_kendaraan]" class="custom-input merk_kendaraan" readonly required></td>
                                <td><input type="number" name="kendaraan[0][kapasitas_kendaraan]" class="custom-input kapasitas_kendaraan input-kapasitas" min="1" readonly required></td>
                            </tr>
                        `;

                        initSelectize(0, jenisKendaraan, true, 'Pilih, cari atau tambahkan Kendaraan');
                        const selectizeControl = $(`#select_nopol_0`)[0].selectize;
                        selectizeControl.clearOptions();

                        if (data.length === 0) {
                            selectizeControl.addOption({
                                nomor_kendaraan: '',
                                merk_kendaraan: 'Tidak ada kendaraan tersedia',
                                kapasitas_kendaraan: 0,
                                kapasitas_tersedia: 0
                            });
                            //selectizeControl.disable();
                        } else {
                            data.forEach(k => {
                                selectizeControl.addOption({
                                    nomor_kendaraan: k.nomor_kendaraan,
                                    merk_kendaraan: k.merk_kendaraan,
                                    kapasitas_kendaraan: k.kapasitas_kendaraan,
                                    kapasitas_tersedia: k.kapasitas_tersedia,
                                    tujuan_penggunaan_1: k.tujuan_penggunaan_1,
                                    tujuan_penggunaan_2: k.tujuan_penggunaan_2,
                                    tujuan_penggunaan_3: k.tujuan_penggunaan_3
                                });
                            });
                            selectizeControl.enable();
                        }
                        selectizeControl.refreshOptions(false);
                        selectizeControl.on('change', function(value) {
                            const selected = kendaraanList.find(k => k.nomor_kendaraan === value);
                            const merkField = $(`input[name="kendaraan[0][merk_kendaraan]"]`);
                            const kapasitasField = $(`input[name="kendaraan[0][kapasitas_kendaraan]"]`);

                            if (selected && selected.nomor_kendaraan) {
                                merkField.val(selected.merk_kendaraan).prop('readonly', !selected.isNew);
                                kapasitasField.val(selected.kapasitas_tersedia || selected.kapasitas_kendaraan).prop('readonly', !selected.isNew);
                                selectedVehicleCapacity = parseInt(selected.kapasitas_tersedia) || parseInt(selected.kapasitas_kendaraan) || null;
                                tujuan1.value = selected.tujuan_penggunaan_1 || "";
                                tujuan2.value = selected.tujuan_penggunaan_2 || "";
                                tujuan3.value = selected.tujuan_penggunaan_3 || "";
                                if (selected.tujuan_penggunaan_1) {
                                    tujuan1.setAttribute("readonly", "readonly");
                                    tujuan2.setAttribute("readonly", "readonly");
                                    tujuan3.setAttribute("readonly", "readonly");
                                } else {
                                    tujuan1.removeAttribute("readonly");
                                    tujuan2.removeAttribute("readonly");
                                    tujuan3.removeAttribute("readonly");
                                }
                            } else {
                                merkField.val('').prop('readonly', false);
                                kapasitasField.val('').prop('readonly', false);
                                selectedVehicleCapacity = null;
                                tujuan1.value = "";
                                tujuan2.value = "";
                                tujuan3.value = "";
                                tujuan1.removeAttribute("readonly");
                                tujuan2.removeAttribute("readonly");
                                tujuan3.removeAttribute("readonly");
                            }
                            validatePesertaCount();
                        });

                    } else if (jenisKendaraan === "1") {
                        kendaraanKantorGroup.style.display = "block";
                        kendaraanSelect.setAttribute("required", "required");
                        kendaraanSelect.innerHTML = `<option value="" disabled selected>Pilih Kendaraan</option>`;

                        if (data.length === 0) {
                            kendaraanSelect.innerHTML = `<option value="" disabled>Tidak ada kendaraan tersedia</option>`;
                            kendaraanSelect.disabled = true;
                        } else {
                            data.forEach(k => {
                                kendaraanSelect.innerHTML += `
                                    <option value="${k.kendaraan_dinas_id}" 
                                            data-kapasitas="${k.kapasitas_tersedia}"
                                            data-tujuan1="${k.tujuan_penggunaan_1 || ''}"
                                            data-tujuan2="${k.tujuan_penggunaan_2 || ''}"
                                            data-tujuan3="${k.tujuan_penggunaan_3 || ''}">
                                        ${k.nomor_kendaraan} - ${k.merk_kendaraan} (Kapasitas Tersedia: ${k.kapasitas_tersedia})
                                    </option>`;
                            });
                        }

                        $('#kendaraan_dinas_id').selectize({
                            create: false,
                            sortField: 'text',
                            valueField: 'value',
                            labelField: 'text',
                            searchField: ['text'],
                            placeholder: 'Pilih atau cari Kendaraan',
                            onChange: function(value) {
                                const selectedOption = kendaraanList.find(k => k.kendaraan_dinas_id == value);
                                selectedVehicleCapacity = selectedOption ? parseInt(selectedOption.kapasitas_tersedia) : null;
                                if (selectedOption && selectedOption.tujuan_penggunaan_1) {
                                    tujuan1.value = selectedOption.tujuan_penggunaan_1 || "";
                                    tujuan2.value = selectedOption.tujuan_penggunaan_2 || "";
                                    tujuan3.value = selectedOption.tujuan_penggunaan_3 || "";
                                    tujuan1.setAttribute("readonly", "readonly");
                                    tujuan2.setAttribute("readonly", "readonly");
                                    tujuan3.setAttribute("readonly", "readonly");
                                } else {
                                    tujuan1.value = "";
                                    tujuan2.value = "";
                                    tujuan3.value = "";
                                    tujuan1.removeAttribute("readonly");
                                    tujuan2.removeAttribute("readonly");
                                    tujuan3.removeAttribute("readonly");
                                }
                                validatePesertaCount();
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Gagal mengambil data kendaraan:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memuat Data',
                        text: 'Terjadi kesalahan saat mengambil data kendaraan. Silakan coba lagi.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#0d6efd'
                    });
                    kendaraanSelect.innerHTML = `<option value="" disabled>Gagal memuat data</option>`;
                    kendaraanSelect.disabled = true;
                    tujuan1.value = "";
                    tujuan2.value = "";
                    tujuan3.value = "";
                    tujuan1.removeAttribute("readonly");
                    tujuan2.removeAttribute("readonly");
                    tujuan3.removeAttribute("readonly");
                });
        }

        function initSelectize(index, jenis, allowAdd = false, placeholderText = '') {
            const selectEl = $(`#select_nopol_${index}`);
            selectEl.selectize({
                valueField: 'nomor_kendaraan',
                labelField: 'nomor_kendaraan',
                searchField: ['nomor_kendaraan', 'merk_kendaraan'],
                create: allowAdd ? function(input) {
                    const newData = {
                        nomor_kendaraan: input,
                        merk_kendaraan: '',
                        kapasitas_kendaraan: '',
                        kapasitas_tersedia: '',
                        isNew: true
                    };
                    kendaraanList.push(newData);
                    setTimeout(() => {
                        selectEl[0].selectize.setValue(input);
                    }, 10);
                    return newData;
                } : false,
                placeholder: placeholderText,
                onChange: function(value) {
                    const selected = kendaraanList.find(k => k.nomor_kendaraan === value);
                    const merkField = $(`input[name="kendaraan[${index}][merk_kendaraan]"]`);
                    const kapasitasField = $(`input[name="kendaraan[${index}][kapasitas_kendaraan]"]`);
                    const tujuan1 = document.querySelector('input[name="tujuan_penggunaan_1"]');
                    const tujuan2 = document.querySelector('input[name="tujuan_penggunaan_2"]');
                    const tujuan3 = document.querySelector('input[name="tujuan_penggunaan_3"]');

                    if (selected && selected.nomor_kendaraan) {
                        merkField.val(selected.merk_kendaraan).prop('readonly', !selected.isNew);
                        kapasitasField.val(selected.kapasitas_tersedia || selected.kapasitas_kendaraan).prop('readonly', !selected.isNew);
                        selectedVehicleCapacity = parseInt(selected.kapasitas_tersedia) || parseInt(selected.kapasitas_kendaraan) || null;
                        if (selected.kendaraan_dinas_id) {
                            $(`input[name="kendaraan[${index}][kendaraan_dinas_id]"]`).val(selected.kendaraan_dinas_id);
                        } else {
                            $(`input[name="kendaraan[${index}][kendaraan_dinas_id]"]`).val('');
                        }
                        if (selected.tujuan_penggunaan_1) {
                            tujuan1.value = selected.tujuan_penggunaan_1 || "";
                            tujuan2.value = selected.tujuan_penggunaan_2 || "";
                            tujuan3.value = selected.tujuan_penggunaan_3 || "";
                            tujuan1.setAttribute("readonly", "readonly");
                            tujuan2.setAttribute("readonly", "readonly");
                            tujuan3.setAttribute("readonly", "readonly");
                        } else {
                            tujuan1.value = "";
                            tujuan2.value = "";
                            tujuan3.value = "";
                            tujuan1.removeAttribute("readonly");
                            tujuan2.removeAttribute("readonly");
                            tujuan3.removeAttribute("readonly");
                        }
                    } else {
                        merkField.val('').prop('readonly', false);
                        kapasitasField.val('').prop('readonly', false);
                        selectedVehicleCapacity = null;
                        $(`input[name="kendaraan[${index}][kendaraan_dinas_id]"]`).val('');
                        tujuan1.value = "";
                        tujuan2.value = "";
                        tujuan3.value = "";
                        tujuan1.removeAttribute("readonly");
                        tujuan2.removeAttribute("readonly");
                        tujuan3.removeAttribute("readonly");
                    }
                    validatePesertaCount();
                }
            });
        }


        $ikutSertaButton.on('click', function() {
            const $bookingRow = $('#bookingTableBody tr').first();
            const noPolisi = $bookingRow.find('td').eq(1).text();
            const jenisKendaraan = $bookingRow.find('td').eq(2).text();
            const waktuPergi = $bookingRow.find('td').eq(3).text();
            const tanggalPenggunaan = $bookingRow.find('td').eq(4).text();
            const tujuan1 = $bookingRow.find('td').eq(5).text();
            const tujuan2 = $bookingRow.find('td').eq(6).text();
            const tujuan3 = $bookingRow.find('td').eq(7).text();
            const alsanPenggunaan = $bookingRow.find('td').eq(8).text();

            const event = globalCalendar.getEventById(globalCalendar.currentEventId);
            const kendaraanDinasId = event?.extendedProps.kendaraan_dinas_id ?? null;
            selectedVehicleCapacity = currentEventCapacity;
            console.log('Selected Vehicle Capacity ikutSertaButton:', selectedVehicleCapacity);
            console.log('Event ID ikutSertaButton:', globalCalendar.currentEventId);

            if (!kendaraanDinasId || selectedVehicleCapacity <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: !kendaraanDinasId ? 'Kendaraan Tidak Valid' : 'Kapasitas Penuh',
                    text: !kendaraanDinasId ? 'Kendaraan tidak ditemukan. Silakan pilih ulang.' : 'Kendaraan ini sudah penuh. Silakan pilih kendaraan lain.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d6efd'
                });
                return;
            }

            const jenisMapping = { 'KANTOR': 1, 'PRIBADI': 2, 'TAXI': 3 };
            const jenisKendaraanId = jenisMapping[jenisKendaraan] || 1;

            $('#ikut_tujuan_penggunaan_1').val(tujuan1 !== '-' ? tujuan1 : '');
            $('#ikut_tujuan_penggunaan_2').val(tujuan2 !== '-' ? tujuan2 : '');
            $('#ikut_tujuan_penggunaan_3').val(tujuan3 !== '-' ? tujuan3 : '');
            $("#ikut_waktu_pergi").val(waktuPergi !== '-' ? waktuPergi : '');
            $('#ikut_tanggal_penggunaan').val(tanggalPenggunaan !== '-' ? tanggalPenggunaan : '');
            $('#ikut_jenis_kendaraan').val(jenisKendaraanId);
            $('#ikut_alasan_penggunaan').val(alsanPenggunaan !== '-' ? alsanPenggunaan : '');
            $('#ikut_kendaraan_dinas_id').val(kendaraanDinasId);
            $('#hidden_nrp_peserta_0_ikutserta').val(nrpValue); // Set hidden input awal

            $tambahIkutSertaModal.on('show.bs.modal', function() {
                counterIkutserta = 0;
                $pesertaTableBody.empty();
                tambahPesertaIkutSerta();
                // Pastikan baris pertama diisi dengan NRP
                setFirstParticipant(nrpValue, 'ikutserta');
            });

            $tambahIkutSertaModal.modal('show');
        });

        $(document).ready(function () {  
            // Event untuk menangani klik elemen dengan id modalPengajuan
            $('#modalPengajuanTrigger').on('click', function () {
                $('#modalPengajuan').modal('show');
                loadTableData();

            });

            function loadTableData() {
                $.ajax({
                    url: "/pengeluaran/get-data-level4",
                    method: "GET",
                    success: function (data) {
                        console.log(data.barang_keluar);
                        const data_barang = data.barang_keluar;

                        const tbody = document.getElementById('detailBody');
                        tbody.innerHTML = '';

                        tbody.innerHTML = data_barang.map((item, index) => {
                            return `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.pengeluaran_barang_id}</td>
                                    <td>${item.created_by}</td>
                                    <td>${item.created_date}</td>
                                    <td>${item.lokasi_barang_keluar}</td>
                                    <td>${item.tujuan_pengeluaran_barang}</td>
                                    <td>${item.jenis_kendaraan}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="getQrCodeBarangKeluar('${item.pengeluaran_barang_id}')">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        }).join('');

                        // Hancurkan DataTable jika sudah ada
                        if ($.fn.DataTable.isDataTable('#dataTable')) {
                            $('#dataTable').DataTable().destroy();
                        }

                        // Inisialisasi ulang DataTable
                        $('#dataTable').DataTable({
                            columnDefs: [
                                { className: 'dt-body-center dt-head-center', targets: 0 }, 
                                { className: 'dt-head-center', targets: 2 },
                                { className: 'dt-body-left', targets: 2},
                                { className: 'dt-head-center', targets: 3 },
                                { className: 'dt-body-right', targets: 3},
                                { className: 'dt-head-center', targets: 4 },
                                { className: 'dt-body-left', targets: 4},
                                { className: 'dt-head-center', targets: 5 },
                                { className: 'dt-body-left', targets: 5},
                                { className: 'dt-head-center', targets: 6 },
                                { className: 'dt-body-left', targets: 6},
                                { className: 'dt-body-center dt-head-center', targets: 7 }
                            ],
                            language: {
                                processing: "Memproses...",
                                search: "Cari:",
                                lengthMenu: "Tampilkan _MENU_ entri",
                                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                                infoEmpty: "Tidak ada data",
                                infoFiltered: "(difilter dari _MAX_ total entri)",
                                loadingRecords: "Memuat...",
                                zeroRecords: "Tidak ditemukan data yang cocok",
                                emptyTable: "Tidak ada data di tabel"
                            },
                            scrollX: false,  
                            responsive: true
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching table data:', error);
                    }
                });
            }

        });

        // Fungsi untuk menampilkan modal edit approval
        function getQrCodeBarangKeluar(pengeluaranBarangId) {
            $.ajax({
                url: "{{ route('pengeluaran.generateQrCodeBarang') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    pengeluaran_barang_id: pengeluaranBarangId
                },
                success: function(response) {
                    $('#btnPrintQR').hide();
                    $('#btnSaveApproval').show();
                    //gunakan untuk membuat input field menjadi read only
                    if (response.no_polisi) {
                        $('#btnPrintQR').show();
                        $('#noPolisi').val(response.no_polisi).prop('readonly', true);
                        $('#btnSaveApproval').hide();
                    } else {
                        $('#noPolisi').val('').prop('readonly', false);
                        $('#btnSaveApproval').show();
                    }

                    // Isi field pada modal
                    $('#pengeluaranBarangId').val(response.pengeluaran_barang_id);
                    $('#asal').val(response.lokasi_barang_keluar);
                    $('#tujuan').val(response.tujuan_pengeluaran_barang);
                    $('#jenisKendaraan').val(response.jenis_kendaraan);

                    // Nonaktifkan input yang tidak perlu diubah
                    $('#pengeluaranBarangId, #tujuan, #jenisKendaraan').prop('disabled', true);

                    // Inisialisasi DataTable
                    let table = $('#barangKeluarTable').DataTable();
                    
                    // Hancurkan DataTable jika sudah ada agar tidak menumpuk data lama
                    if ($.fn.DataTable.isDataTable('#barangKeluarTable')) {
                        table.destroy();
                    }

                    // Kosongkan isi tabel
                    let tbody = $('#barangKeluarTable tbody');
                    tbody.empty();

                    // Tambahkan data ke tabel
                    if (response.barangKeluar && response.barangKeluar.length > 0) {
                        $.each(response.barangKeluar, function(index, barangInfo) {
                            tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${barangInfo.nama_barang}</td>
                                    <td>${Number(barangInfo.jumlah_barang).toLocaleString('id-ID')}</td>
                                    <td>${barangInfo.satuan_barang}</td>
                                    <td>${barangInfo.keterangan_barang?.trim() ? barangInfo.keterangan_barang : '-'}</td>

                                </tr>
                            `);
                        });
                    } else {
                        tbody.append('<tr><td colspan="5" class="text-center">Tidak ada data barang</td></tr>');
                    }

                    // Inisialisasi ulang DataTable setelah data diisi
                    $('#barangKeluarTable').DataTable({
                        columnDefs: [
                            { className: 'dt-head-center', targets: 0 },
                            { className: 'dt-head-center', targets: 1 },
                            { className: 'dt-head-center', targets: 2 }, 
                            { className: 'dt-head-center', targets: 3 },
                            { className: 'dt-head-center', targets: 4 },
                            { className: 'dt-body-center', targets: 0 }
                        ],
                        language: {
                                processing: "Memproses...",
                                search: "Cari:",
                                lengthMenu: "Tampilkan _MENU_ entri",
                                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                                infoEmpty: "Tidak ada data",
                                infoFiltered: "(difilter dari _MAX_ total entri)",
                                loadingRecords: "Memuat...",
                                zeroRecords: "Tidak ditemukan data yang cocok",
                                emptyTable: "Tidak ada data di tabel"
                        },
                        responsive: true,
                        autoWidth: false,
                        scrollX: false,
                        destroy: true,
                        retrieve: true,
                        pageLength: 5, // Menampilkan 5 data per halaman
                        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]] // Pilihan jumlah data per halaman
                    });

                    // Update container QR Code dengan output dari BaconQrCode
                    $('#qrcodePengeluaranBarang').html(response.qr_code_barang);

                    // Buat konten barang keluar untuk ditampilkan di dalam iframe
                   let barangContent = '';
                    if (response.barangKeluar && response.barangKeluar.length > 0) {
                        barangContent += '<table style="width:100%; border-collapse: collapse;" border="1">';
                        barangContent += '<thead><tr>';
                        barangContent += '<th>No</th>';
                        barangContent += '<th>Nama Barang</th>';
                        barangContent += '<th>Jumlah</th>';
                        barangContent += '<th>Satuan</th>';
                        barangContent += '</tr></thead><tbody>';

                        response.barangKeluar.forEach((barang, index) => {
                            barangContent += `
                                <tr>
                                    <td rowspan="2">${index + 1}</td>
                                    <td style="text-align: left;">${barang.nama_barang}</td>
                                    <td style="text-align: right;">${Number(barang.jumlah_barang).toLocaleString('id-ID')}</td>
                                    <td style="text-align: left;">${barang.satuan_barang}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;" colspan="3">
                                        ${barang.keterangan_barang?.trim() ? barang.keterangan_barang : '-'}
                                    </td>
                                </tr>
                            `;
                        });

                        barangContent += '</tbody></table>';
                    } else {
                        barangContent = '<p>Tidak ada data barang keluar.</p>';
                    }

                    // Perbarui isi srcdoc pada iframe dengan data terbaru
                    let iframePengeluaranBarang = `
                        <!DOCTYPE html>
                        <html lang="id">
                        <head>
                            <meta charset="UTF-8">
                            <style>
                                body { font-family: Arial, sans-serif; text-align: center; }
                                .container { width: 420px; border: 2px solid black; padding: 10px; margin: auto; }
                                .row { display: flex; justify-content: space-between; align-items: center; }
                                .column-left { width: 60%; }
                                .column-right { width: 38%; text-align: center; }
                                .box { border: 1px solid black; padding: 10px; margin: 5px 0; text-align: center; }
                                .content { min-height: 100px; margin-top: 10px; }
                                .footer { font-size: 12px; text-align: left; margin-top: 10px; }
                                .qrcode { padding: 10px; display: flex; justify-content: center; align-items: center; }
                                .qrcode img { width: 120px; height: 120px; }
                            </style>
                        </head>
                        <body>
                            <div class="container">
                                <div class="row">
                                    <div class="column-left">
                                        <div class="box"><img src="{{ asset('assets/img/Logo B YMI - 2017.png') }}" style="height: 50px;"></div>
                                        <div class="box"><strong>SURAT PENGELUARAN BARANG</strong></div>
                                        <div class="box">${response.pengeluaran_barang_id}</div>
                                    </div>
                                    <div class="column-right">
                                        <div class="box">${response.qr_code_barang}</div>
                                    </div>
                                </div>

                                <div class="box content">${barangContent}</div>

                                <div class="footer">
                                    <div class="row">
                                        <div class="column-left">
                                            MM 2100-Industrial Town Jl. Halmahera Block EE-1 Cikarang Barat, Bekasi 17520
                                        </div>

                                        <div class="column-right">
                                            Phone: +62 21 8980769 
                                            <br> 
                                            Fax: +62 21 8980770
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </body>
                        </html>
                    `;
                    $('#barangKeluarQrFrame').attr('srcdoc', iframePengeluaranBarang).prop('hidden', true);

                    // Tampilkan modal edit approval
                    $('#modalPengajuanBarangDetail').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Tidak dapat mengambil data. Error: ' + error,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        }

        $(document).ready(function () {

            // Event untuk membuka modal surat kendaraan dinas
            $('#modalSuratKendaraanTrigger').on('click', function () {
                $('#modalSuratKendaraan').modal('show');
                loadSuratKendaraanData();
            });

            function loadSuratKendaraanData() {
                $.ajax({
                    url: "/pengajuan/get-data-level3", // Ubah sesuai route Anda
                    method: "GET",
                    success: function (data) {
                        console.log(data.surat_kendaraan_dinas);
                        const suratData = data.surat_kendaraan_dinas;

                        const tbody = document.getElementById('suratKendaraanBody');
                        tbody.innerHTML = '';

                        tbody.innerHTML = suratData.map((item, index) => {
                            const jenisKendaraanMapping = {
                                1: 'KANTOR',
                                2: 'PRIBADI',
                                3: 'TAXI'
                            };
                            const jenisKendaraan = jenisKendaraanMapping[item.jenis_kendaraan] || '-';
                            return `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.surat_kendaraan_dinas_id}</td>
                                    <td>${item.created_by}</td>
                                    <td>${item.created_date}</td>
                                    <td>${item.tujuan_penggunaan_1 || '-'} ${item.tujuan_penggunaan_2 || ''} ${item.tujuan_penggunaan_3 || ''}</td>
                                    <td>${jenisKendaraan}</td>
                                    <td>${item.tanggal_penggunaan}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="getQrCodePenggunaanKendaraanDinas('${item.surat_kendaraan_dinas_id}')">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        }).join('');

                        if ($.fn.DataTable.isDataTable('#suratKendaraanTable')) {
                            $('#suratKendaraanTable').DataTable().destroy();
                        }

                        $('#suratKendaraanTable').DataTable({
                            columnDefs: [
                                { className: 'dt-body-center dt-head-center', targets: 0 }, 
                                { className: 'dt-head-center', targets: 2 },
                                { className: 'dt-body-left', targets: 2},
                                { className: 'dt-head-center', targets: 3 },
                                { className: 'dt-body-right', targets: 3},
                                { className: 'dt-head-center', targets: 4 },
                                { className: 'dt-body-left', targets: 4},
                                { className: 'dt-head-center', targets: 5 },
                                { className: 'dt-body-left', targets: 5},
                                { className: 'dt-head-center', targets: 6 },
                                { className: 'dt-body-right', targets: 6},
                                { className: 'dt-body-center dt-head-center', targets: 7 },
                            ],
                            language: {
                                processing: "Memproses...",
                                search: "Cari:",
                                lengthMenu: "Tampilkan _MENU_ entri",
                                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                                infoEmpty: "Tidak ada data",
                                infoFiltered: "(difilter dari _MAX_ total entri)",
                                loadingRecords: "Memuat...",
                                zeroRecords: "Tidak ditemukan data yang cocok",
                                emptyTable: "Tidak ada data di tabel"
                            },
                            scrollX: false,
                            responsive: true
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('Gagal mengambil data surat kendaraan:', error);
                    }
                });
            }

        });

        function getQrCodePenggunaanKendaraanDinas(suratKendaraanId) {
            $.ajax({
                url: "{{ route('pengajuan.generateQrCodeSuratKendaraan') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    surat_kendaraan_dinas_id: suratKendaraanId
                },
                success: function(response) {
            
                    // Inisialisasi DataTable
                    let table = $('#pesertaTableDinas').DataTable();
                    
                    if ($.fn.DataTable.isDataTable('#pesertaTableDinas')) {
                        table.destroy();
                    }

                    // Kosongkan isi tabel
                    let tbody = $('#pesertaTableDinas tbody');
                    tbody.empty();

                    if (response.peserta_sama_tujuan && response.peserta_sama_tujuan.length > 0) {
                        $.each(response.peserta_sama_tujuan, function(index, peserta) {
                            tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${peserta.surat_kendaraan_dinas_id}</td>
                                    <td>${peserta.nrp}</td>
                                    <td>${peserta.nama}</td>
                                    <td>${peserta.departemen}</td>
                                </tr>
                            `);
                        });
                    } else {
                        tbody.append('<tr><td colspan="5" class="text-center">Tidak ada peserta dinas</td></tr>');
                    }


                    // Inisialisasi ulang DataTable setelah data diisi
                    $('#pesertaTableDinas').DataTable({
                        columnDefs: [
                            { className: 'dt-body-center dt-head-center', targets: 0 }, 
                            { className: 'dt-head-center', targets: 1 },
                            { className: 'dt-head-center', targets: 2 },
                            { className: 'dt-head-center', targets: 3 },

                            { className: 'dt-body-left', targets: 1}
                        ],
                        language: {
                                processing: "Memproses...",
                                search: "Cari:",
                                lengthMenu: "Tampilkan _MENU_ entri",
                                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                                infoEmpty: "Tidak ada data",
                                infoFiltered: "(difilter dari _MAX_ total entri)",
                                loadingRecords: "Memuat...",
                                zeroRecords: "Tidak ditemukan data yang cocok",
                                emptyTable: "Tidak ada data di tabel"
                        },
                        responsive: true,
                        autoWidth: false,
                        scrollX: false,
                        destroy: true,
                        retrieve: true,
                        pageLength: 5, // Menampilkan 5 data per halaman
                        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]] // Pilihan jumlah data per halaman
                    });

                    // Update container QR Code dengan output dari BaconQrCode
                    $('#qrcodeDinasContainer').html(response.qr_code_dinas);

                    let userDinasContent = '';
                    if (response.peserta_sama_tujuan && response.peserta_sama_tujuan.length > 0) {
                        userDinasContent += '<table style="width:100%; border-collapse: collapse; font-size: 8pt;" border="1">';
                        userDinasContent += '<thead><tr>';
                        userDinasContent += '<th style="white-space: nowrap;">No</th>';
                        userDinasContent += '<th style="white-space: nowrap;">No Surat Dinas</th>';
                        userDinasContent += '<th style="white-space: nowrap;">NRP</th>';
                        userDinasContent += '<th style="white-space: nowrap;">Nama</th>';
                        userDinasContent += '<th style="white-space: nowrap;">Departemen</th>';
                        userDinasContent += '</tr></thead><tbody>';
                        response.peserta_sama_tujuan.forEach((peserta, index) => {
                            userDinasContent += `<tr>
                                <td>${index + 1}</td>
                                <td style="text-align: left;">${peserta.surat_kendaraan_dinas_id}</td>
                                <td style="text-align: left;">${peserta.nrp}</td>
                                <td style="text-align: left;">${peserta.nama}</td>
                                <td style="text-align: left;">${peserta.departemen}</td>
                            </tr>`;
                        });
                        userDinasContent += '</tbody></table>';
                    } else {
                        userDinasContent = '<p style="font-size: 8pt;">Tidak ada data peserta dinas.</p>';
                    }


                    // Perbarui isi srcdoc pada iframe dengan data terbaru
                    let iframePenggunaanKendaraanDinas = `
                        <!DOCTYPE html>
                        <html lang="id">
                        <head>
                            <meta charset="UTF-8">
                            <style>
                                body { font-family: Arial, sans-serif; text-align: center; }
                                .container { width: 420px; border: 2px solid black; padding: 10px; margin: auto; }
                                .row { display: flex; justify-content: space-between; align-items: center; }
                                .column-left { width: 60%; }
                                .column-right { width: 38%; text-align: center; }
                                .box { border: 1px solid black; padding: 10px; margin: 5px 0; text-align: center; }
                                .content { min-height: 100px; margin-top: 10px; }
                                .footer { font-size: 12px; text-align: left; margin-top: 10px; }
                                .qrcode { padding: 10px; display: flex; justify-content: center; align-items: center; }
                                .qrcode img { width: 120px; height: 120px; }
                            </style>
                        </head>
                        <body>
                            <div class="container">
                                <div class="row">
                                    <div class="column-left">
                                        <div class="box"><img src="{{ asset('assets/img/Logo B YMI - 2017.png') }}" style="height: 50px;"></div>
                                        <div class="box"><strong>SURAT PENGGUNAAN KENDARAAN DINAS</strong></div>
                                        <div class="box">${response.surat_kendaraan_dinas_id}</div>
                                    </div>
                                    <div class="column-right">
                                        <div class="box">${response.qr_code_dinas}</div>
                                    </div>
                                </div>

                                <div class="box content">${userDinasContent}</div>

                                <div class="footer">
                                    <div class="row">
                                        <div class="column-left">
                                            MM 2100-Industrial Town Jl. Halmahera Block EE-1 Cikarang Barat, Bekasi 17520
                                        </div>

                                        <div class="column-right">
                                            Phone: +62 21 8980769 
                                            <br> 
                                            Fax: +62 21 8980770
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </body>
                        </html>
                    `;
                    $('#pesertaDinasQrFrame').attr('srcdoc', iframePenggunaanKendaraanDinas).prop('hidden', true);

                    // Tampilkan modal edit approval
                    $('#modalPenggunaanKendaraanDinasDetail').modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Tidak dapat mengambil data. Error: ' + error,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        }


        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Function to validate participant count against vehicle capacity
        function validatePesertaCount() {
            const pesertaTable = document.getElementById('pesertaTableTambah').getElementsByTagName('tbody')[0];
            const pesertaCount = pesertaTable.getElementsByTagName('tr').length;
            
            if (selectedVehicleCapacity && pesertaCount > selectedVehicleCapacity) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Jumlah Peserta Melebihi Kapasitas',
                    text: `Kapasitas kendaraan adalah ${selectedVehicleCapacity}`,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d6efd'
                });
                // Remove excess rows
                while (pesertaTable.getElementsByTagName('tr').length > selectedVehicleCapacity) {
                    pesertaTable.deleteRow(-1);
                }
                updateNomorPeserta();
            }
        }


        document.addEventListener("DOMContentLoaded", function () {
            const inputKm = document.getElementById("kilometer_awal");

            inputKm.addEventListener("input", function (e) {
                let value = this.value.replace(/[^0-9]/g, ''); // Remove non-digits
                if (value) {
                    this.value = Number(value).toLocaleString('id-ID'); // Format with thousand separators
                }
            });
        });

        document.addEventListener('input', function (e) {
            if (e.target.classList.contains('jumlah-input')) {
            // Ambil angka, hapus karakter non-digit
            let val = e.target.value.replace(/\D/g, '');

            // Hapus semua 0 di depan, tapi tetap izinkan angka '0' tunggal
            if (val.length > 1) {
                val = val.replace(/^0+/, '');
            }

            // Jika hanya 0 saja, kosongkan (tidak valid)
            if (val === '0') val = '';

            // Maksimal 6 digit
            e.target.value = val.slice(0, 6);
            }
        });

        document.addEventListener('input', function (e) {
            if (e.target.classList.contains('input-kapasitas')) {
                // Ambil angka, hapus karakter non-digit
                let val = e.target.value.replace(/\D/g, '');

                // Hapus semua 0 di depan, tapi tetap izinkan angka '0' tunggal
                if (val.length > 1) {
                val = val.replace(/^0+/, '');
                }

                // Jika hanya 0 saja, kosongkan (tidak valid)
                if (val === '0') val = '';

                // Maksimal 2 digit
                e.target.value = val.slice(0, 2);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Get input elements
            const areaCode = document.getElementById('area_code');
            const numberPart = document.getElementById('number_part');
            const letterCode = document.getElementById('letter_code');
            const hiddenInput = document.getElementById('no_polisi');
            const errorMsg = document.getElementById('no_polisi_error');

            // Function to update hidden input
            function updateHiddenInput() {
                const area = areaCode.value.toUpperCase().trim();
                const number = numberPart.value.trim();
                const letter = letterCode.value.toUpperCase().trim();
                
                // Update hidden input only if all fields are filled
                if (area && number && letter) {
                    const fullPlate = `${area} ${number} ${letter}`;
                    hiddenInput.value = fullPlate;
                    errorMsg.style.display = 'none';
                } else {
                    hiddenInput.value = '';
                }
            }

            // Validation and auto-focus for area code (letters only)
            areaCode.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^A-Za-z]/g, '').toUpperCase();
                updateHiddenInput();
                
                // Auto focus to next field when max length reached
                if (e.target.value.length === 2) {
                    numberPart.focus();
                }
            });

            // Validation and auto-focus for number part (numbers only)
            numberPart.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^0-9]/g, '');
                updateHiddenInput();
                
                // Auto focus to next field when max length reached
                if (e.target.value.length === 4) {
                    letterCode.focus();
                }
            });

            // Validation for letter code (letters only)
            letterCode.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^A-Za-z]/g, '').toUpperCase();
                updateHiddenInput();
            });

            // Handle backspace for auto focus to previous field
            [areaCode, numberPart, letterCode].forEach((input, index) => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                        const prevInput = [areaCode, numberPart, letterCode][index - 1];
                        prevInput.focus();
                    }
                });
            });

            // Form validation before submit
            const form = document.getElementById('tambah_pengeluaran_barang');
            if (form) {
                // Override the default validation to include license plate check
                const originalCheckValidity = form.checkValidity;
                form.checkValidity = function() {
                    const area = areaCode.value.trim();
                    const number = numberPart.value.trim();
                    const letter = letterCode.value.trim();
                    
                    // Check if license plate is complete
                    if (!area || !number || !letter) {
                        errorMsg.style.display = 'block';
                        errorMsg.textContent = 'Mohon lengkapi semua bagian nomor polisi.';
                        
                        // Focus on first empty field
                        if (!area) areaCode.focus();
                        else if (!number) numberPart.focus();
                        else if (!letter) letterCode.focus();
                        
                        return false;
                    } else {
                        errorMsg.style.display = 'none';
                        // Call original checkValidity for other form elements
                        return originalCheckValidity.call(this);
                    }
                };
            }

            // Initial update
            updateHiddenInput();
        });

        $(document).ready(function () {
            const lokasiSelect = $('#lokasi_barang_keluar').selectize({
                create: true,
                sortField: 'text',
                onChange: validateLokasiTujuan
            });

            const tujuanSelect = $('#tujuan_pengeluaran_barang').selectize({
                create: true,
                sortField: 'text',
                onChange: validateLokasiTujuan
            });

            function validateLokasiTujuan() {
                const lokasi = lokasiSelect[0].selectize.getValue().trim().toLowerCase();
                const tujuan = tujuanSelect[0].selectize.getValue().trim().toLowerCase();
                const errorMsg = $('#lokasi_tujuan_error');

                if (lokasi && tujuan && lokasi === tujuan) {
                    errorMsg.show();
                } else {
                    errorMsg.hide();
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Form Pengeluaran Barang
            const form = document.getElementById('tambah_pengeluaran_barang');
            const submitButton = form?.querySelector('button[type="submit"]');

            // Form Penggunaan Kendaraan Dinas
            const formDinas = document.getElementById('tambah_penggunaan_kendaraan_dinas');
            const submitButtonDinas = formDinas?.querySelector('button[type="submit"]');

            // Form Ikut Serta
            const formIkutSerta = document.getElementById('formTambahikutserta');
            const submitButtonIkutSerta = formIkutSerta?.querySelector('button[type="submit"]');

            // Handler untuk Form Pengeluaran Barang
            if (submitButton && form) {
                submitButton.addEventListener('click', function (e) {
                    // Cek validasi form terlebih dahulu
                    if (form.checkValidity()) {
                        e.preventDefault(); // Cegah submit bawaan
                        
                        Swal.fire({
                            title: 'Apakah Anda Yakin?',
                            text: "Pastikan seluruh data pengeluaran barang telah diisi dengan benar.",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Ajukan',
                            cancelButtonText: 'Tinjau Ulang',
                            reverseButtons: true,
                            confirmButtonColor: '#0d6efd',
                            cancelButtonColor: '#6c757d',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Submit form jika dikonfirmasi
                            }
                        });
                    } else {
                        // Trigger browser untuk menampilkan error bawaan HTML5
                        form.reportValidity();
                    }
                });
            }

            // Handler untuk Form Penggunaan Kendaraan Dinas
           if (submitButtonDinas && formDinas) {
                submitButtonDinas.addEventListener('click', function (e) {
                   // Cek validasi form terlebih dahulu
                    if (formDinas.checkValidity()) {
                        e.preventDefault(); // Cegah submit bawaan

                        // Ambil semua elemen select NRP
                        const nrpSelects = formDinas.querySelectorAll('select[name^="peserta"][name$="[nrp_karyawan]"]');
                        const nrpValues = [];

                        let duplicateFound = false;
                        nrpSelects.forEach(select => {
                            const value = select.value;
                            if (value) {
                                if (nrpValues.includes(value)) {
                                    duplicateFound = true;
                                } else {
                                    nrpValues.push(value);
                                }
                            }
                        });

                        if (duplicateFound) {
                            Swal.fire({
                                icon: 'error',
                                title: 'NRP Duplikat',
                                text: 'Terdapat NRP yang sama dalam daftar peserta. Mohon periksa kembali.',
                            });
                            return;
                        }

                        // Lanjut konfirmasi swal jika tidak ada duplikat
                        Swal.fire({
                            title: 'Apakah Anda Yakin?',
                            text: "Pastikan seluruh data peserta telah diisi dengan benar.",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Tambahkan',
                            cancelButtonText: 'Tinjau Ulang',
                            reverseButtons: true,
                            confirmButtonColor: '#0d6efd',
                            cancelButtonColor: '#6c757d'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                formDinas.submit(); // Submit form jika dikonfirmasi
                            }
                        });
                    } else {
                        // Trigger browser untuk menampilkan error bawaan HTML5
                        formDinas.reportValidity();
                    }
                });
            }

            // Handler untuk Form Ikut Serta
            if (submitButtonIkutSerta && formIkutSerta) {
                submitButtonIkutSerta.addEventListener('click', function (e) {
                    // Cek validasi form terlebih dahulu
                    if (formIkutSerta.checkValidity()) {
                        e.preventDefault(); // Cegah submit bawaan

                        // Ambil semua elemen select NRP
                        const nrpSelects = formIkutSerta.querySelectorAll('select[name^="peserta"][name$="[nrp_karyawan]"]');
                        const nrpValues = [];

                        let duplicateFound = false;
                        nrpSelects.forEach(select => {
                            const value = select.value;
                            if (value) {
                                if (nrpValues.includes(value)) {
                                    duplicateFound = true;
                                } else {
                                    nrpValues.push(value);
                                }
                            }
                        });

                        if (duplicateFound) {
                            Swal.fire({
                                icon: 'error',
                                title: 'NRP Duplikat',
                                text: 'Terdapat NRP yang sama dalam daftar peserta. Mohon periksa kembali.',
                            });
                            return;
                        }

                        // Lanjut konfirmasi swal jika tidak ada duplikat
                        Swal.fire({
                            title: 'Apakah Anda Yakin?',
                            text: "Pastikan seluruh data peserta telah diisi dengan benar.",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Tambahkan',
                            cancelButtonText: 'Tinjau Ulang',
                            reverseButtons: true,
                            confirmButtonColor: '#0d6efd',
                            cancelButtonColor: '#6c757d'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                formIkutSerta.submit(); // Submit form jika dikonfirmasi
                            }
                        });
                    } else {
                        // Trigger browser untuk menampilkan error bawaan HTML5
                        formIkutSerta.reportValidity();
                    }
                });
            }
        });



        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        var control = $select[0].selectize;
        var $select = $('#select-tools').selectize({

        create: true
        });

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
    
</x-guest-layout>



