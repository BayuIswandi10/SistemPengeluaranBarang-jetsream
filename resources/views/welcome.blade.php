
<x-guest-layout>
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

        /* Modal benar-benar lebar, hampir penuh, tetap menyamping */
        .modal-slide-side {
            width: calc(90% - 2rem); /* Menyisakan 1rem di kiri dan kanan */
            margin: 4rem auto;
        }

        .modal-slide-side .modal-content {
            height: 90vh;
            overflow-y: auto;
            border-radius: 10px;
            padding: 1rem;
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
                            <a class="nav-link" data-toggle="modal" data-target="#tambahDataModal">Pengajuan Pengeluaran Barang</a></li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#calendarModal">Pengajuan Kendaraan Dinas</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href={{ route('login') }}>Masuk</a></li>
                </ul>
                </div>
            </div>
            
            {{-- Tambah Pengeluaran Barang Modal --}}
            <div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="tambahDataModalLabel">Ajukan Pengeluaran Barang</h5>
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
                                    <input type="text" class="form-control" id="pembawa_scrap" name="pembawa_scrap" placeholder="Masukkan Nama Pembawa Scrap" autocomplete="off">
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
                                    <input type="text" class="form-control" id="no_polisi" name="no_polisi" placeholder="Masukan No Polisi Kendaraan" required autocomplete="off">
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
                                                    <td><input type="text" name="barang_ids[]" class="form-control" placeholder="Nama Barang" required autocomplete="off"></td>
                                                    <td><input type="text" name="jumlah[]" class="form-control jumlah-input" placeholder="Jumlah"required autocomplete="off"></td>
                                                    <td>
                                                        <select name="satuan[]" class="form-control" required>
                                                            <option value="" disabled selected>Pilih Satuan</option>
                                                            <option value="unit">Unit</option>
                                                            <option value="pcs">PCS</option>
                                                            <option value="kg">KG</option>
                                                            <option value="jumbo bag">JUMBO BAG</option>
                                                            <option value="drum">DRUM</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan" autocomplete="off"></td>
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
                            @if(session('clear_local_storage'))
                            <script>
                                localStorage.removeItem('barang_keluar_data');
                            </script>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Kalender Umum -->
            <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-slide-side" role="document" style="max-width: 100%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <!-- Input bulan -->
                            <div>
                                <label for="monthPickerGlobal">Pilih Bulan:</label>
                                <input type="month" id="monthPickerGlobal" class="form-control" style="max-width: 250px;">
                            </div>

                            <!-- Legend kendaraan -->
                            <div class="d-flex align-items-center" id="legendKendaraan">
                                <div class="mr-3 d-flex align-items-center">
                                    <span class="legend-color" style="background-color: #28a745;"></span>
                                    <span class="ml-1">Kendaraan Kantor</span>
                                </div>
                                <div class="mr-3 d-flex align-items-center">
                                    <span class="legend-color" style="background-color: #007bff;"></span>
                                    <span class="ml-1">Kendaraan Pribadi</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="legend-color" style="background-color: #ffc107;"></span>
                                    <span class="ml-1">Taxi</span>
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
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
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
                                                    <select id="select_nopol_0" name="kendaraan[0][nomor_kendaraan]" class="form-control select-nopol" data-index="0" required></select>
                                                </td>
                                                <td><input type="text" name="kendaraan[0][merk_kendaraan]" class="form-control merk_kendaraan" required></td>
                                                <td><input type="number" name="kendaraan[0][kapasitas_kendaraan]" class="form-control kapasitas_kendaraan input-kapasitas" min="1" required></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="form-group">
                                    <label for="tanggal_penggunaan">Tanggal Penggunaan <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_penggunaan" name="tanggal_penggunaan" value="{{ old('tanggal_penggunaan') }}" required autocomplete="off" onchange="toggleJenisKendaraan()">
                                </div>
                                
                                <div class="form-group">
                                    <label for="tujuan_penggunaan">Tujuan Dinas <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-2">
                                        <input type="text" class="form-control" name="tujuan_penggunaan_1" 
                                               value="{{ old('tujuan_penggunaan_1') }}" required autocomplete="off" placeholder="Tujuan Ke-1" required autocomplete="off">
                                        <input type="text" class="form-control" name="tujuan_penggunaan_2" 
                                               value="{{ old('tujuan_penggunaan_2') }}" autocomplete="off" placeholder="Tujuan Ke-2" autocomplete="off">
                                        <input type="text" class="form-control" name="tujuan_penggunaan_3" 
                                               value="{{ old('tujuan_penggunaan_3') }}" autocomplete="off" placeholder="Tujuan Ke-3" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group" id="kendaraan_pribadi_group" style="display: none;">
                                    <label for="kilometer_awal">Kilometer Awal <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="kilometer_awal" name="kilometer_awal" placeholder="Masukkan kilometer awal" autocomplete="off">
                                </div>    
            
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
                                                <td><input type="text" name="peserta[0][nrp_karyawan]" class="form-control nrp_karyawan" placeholder="NRP Karyawan" required autocomplete="off"></td>
                                                <td><input type="text" name="peserta[0][nama]" class="form-control nama" placeholder="Nama" readonly></td>
                                                <td><input type="text" name="peserta[0][departemen]" class="form-control departemen" placeholder="Departemen" readonly></td>

                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBoxPeserta(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-success btn-sm" onclick="tambahComboBoxPeserta()">
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
            {{-- <div class="modal fade" id="ikutSertaDinasModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="editDataModalLabel">Ikut Serta Kendaraan Dinas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Informasi Nomor Surat -->
                            <label for="nomorSurat" class="mt-2">Nomor Surat <span class="text-danger">*</span></label>
                            <input type="text" id="nomorSurat" name="nomor_surat" class="form-control" disabled>


                            <!-- Form Edit -->
                            <form id="editOrderForm" method="POST" action="{{route('pengajuan.updateNonAuth')}}" enctype="multipart/form-data" >
                                @csrf
                                
                                <input type="hidden" name="surat_kendaraan_dinas_id" id="hiddenSuratId">

                                <label class="mt-3">Tujuan <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" name="tujuan_penggunaan_1" id="tujuan_1" class="form-control" placeholder="-">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="tujuan_penggunaan_2" id="tujuan_2" class="form-control" placeholder="-">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="tujuan_penggunaan_3" id="tujuan_3" class="form-control" placeholder="-">
                                    </div>
                                </div>


                                <!-- Jenis Mobil -->
                                <label for="jenisMobil" class="mt-2">Jenis Mobil <span class="text-danger">*</span></label>
                                <input type="text" name="jenis_kendaraan" id="jenisMobil" class="form-control">

                                <!-- Digunakan Pada -->
                                <label for="tanggalPakai" class="mt-2">Digunakan Pada <span class="text-danger">*</span></label>
                                <input type="text" name="tanggal_penggunaan" id="tanggalPakai" class="form-control">

                                <!-- Peserta Dinas Table -->
                                <div class="form-group mt-2">
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
                                                <td><input type="text" name="peserta[0][nrp_karyawan]" class="form-control nrp_karyawan" placeholder="NRP Karyawan" required autocomplete="off"></td>
                                                <td><input type="text" name="peserta[0][nama]" class="form-control nama" placeholder="Nama" readonly></td>
                                                <td><input type="text" name="peserta[0][departemen]" class="form-control departemen" placeholder="Departemen" readonly></td>

                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusIkutPeserta(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" id="tambahPesertaBtn" class="btn btn-success btn-sm" onclick="tambahPesertaIkutSerta()">
                                        <i class="fas fa-plus"></i> Tambah Peserta
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
            </div> --}}

            {{-- Ikut Serta Penggunaan Kendaraan Dinas Modal 2--}}
            {{-- <div class="modal fade" id="ikutSertaDinasModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="editDataModalLabel">Ikut Serta Kendaraan Dinas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editOrderForm" method="POST" action="{{route('pengajuan.updateNonAuth')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="surat_kendaraan_dinas_id" id="hiddenSuratId">

                                <!-- Main Information Table -->
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nomor Surat</th>
                                            <th>Jenis Mobil</th>
                                            <th>Tanggal Penggunaan</th>
                                            <th>Tujuan 1</th>
                                            <th>Tujuan 2</th>
                                            <th>Tujuan 3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" id="nomorSurat" name="nomor_surat" class="form-control" disabled></td>
                                            <td><input type="text" name="jenis_kendaraan" id="jenisMobil" class="form-control"></td>
                                            <td><input type="text" name="tanggal_penggunaan" id="tanggalPakai" class="form-control"></td>
                                            <td><input type="text" name="tujuan_penggunaan_1" id="tujuan_1" class="form-control" placeholder="-"></td>
                                            <td><input type="text" name="tujuan_penggunaan_2" id="tujuan_2" class="form-control" placeholder="-"></td>
                                            <td><input type="text" name="tujuan_penggunaan_3" id="tujuan_3" class="form-control" placeholder="-"></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Peserta Dinas Table -->
                                <div class="form-group mt-3">
                                    <label><strong>Peserta Dinas</strong> <span class="text-danger">*</span></label>
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
                                                <td><input type="text" name="peserta[0][nrp_karyawan]" class="form-control nrp_karyawan" placeholder="NRP Karyawan" required autocomplete="off"></td>
                                                <td><input type="text" name="peserta[0][nama]" class="form-control nama" placeholder="Nama" readonly></td>
                                                <td><input type="text" name="peserta[0][departemen]" class="form-control departemen" placeholder="Departemen" readonly></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusIkutPeserta(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" id="tambahPesertaBtn" class="btn btn-success btn-sm" onclick="tambahPesertaIkutSerta()">
                                        <i class="fas fa-plus"></i> Tambah Peserta
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
            </div> --}}

            <div class="modal fade" id="ikutSertaDinasModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editDataModalLabel">Ikut Serta Kendaraan Dinas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Bookings Table -->
                <div class="mb-4">
                    <h6>Kendaraan</h6>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Polisi</th>
                                <th>Jenis Mobil</th>
                                <th>Tanggal Penggunaan</th>
                                <th>Tujuan 1</th>
                                <th>Tujuan 2</th>
                                <th>Tujuan 3</th>
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
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Peserta Dinas Table -->
                <div class="form-group mt-3">
                    <h6>Peserta Dinas</h6>
                    <table id="pesertaTableTambahPeserta" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Surat</th>
                                <th>NRP</th>
                                <th>Nama</th>
                                <th>Departemen</th>
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
                </div>
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
                <div class="card shadow">
                    <div class="card-header text-center"  style="border-top: 5px solid #5A6ACF;">
                        <h4>Pengajuan yang Siap untuk Dicetak</h4>
                    </div>
                    <div class="card-body p-5 bg-white">
                        <div class="row">
                            <!-- Card 1: Pengeluaran Barang -->
                            <div class="col-lg-6 col-md-6 mt-5 mt-md-0 text-center" id="modalPengajuanTrigger">
                                <div class="card shadow card-hover">
                                    <div class="card-body">
                                        <i class="fas fa-box-open text-primary h1"></i>
                                        <h3 class="mt-4 text-capitalize h5">Pengeluaran Barang</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Card 2: Penggunaan Kendaraan Dinas -->
                            <div class="col-lg-6 col-md-6 mt-5 mt-md-0 text-center" id="modalSuratKendaraanTrigger">
                                <div class="card shadow card-hover">
                                    <div class="card-body">
                                        <i class="fas fa-car-side text-primary h1"></i>
                                        <h3 class="mt-4 text-capitalize h5">Penggunaan Kendaraan Dinas</h3>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPengajuanLabel">Detail Jumlah Pengajuan</h5>
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
                                    <th>Aksi</th>
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
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="modalPengajuanBarangDetailLabel">Pemeriksaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <iframe hidden id="barangKeluarQrFrame" width="500" height="400" srcdoc="">
                            Browser Anda tidak mendukung iframe.
                        </iframe>
                        
                        
                        <h6 class="mt-4">Detail Barang</h6>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSuratKendaraanLabel">Detail Jumlah Pengajuan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
        
                        <table id="suratKendaraanTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Surat</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Tujuan</th>
                                    <th>Jenis Kendaraan</th>
                                    <th>Tanggal Penggunaan</th>
                                    <th>Aksi</th>
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
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="modalPenggunaanKendaraanDinasDetailLabel">Pemeriksaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <iframe hidden id="pesertaDinasQrFrame" width="500" height="400" srcdoc="">
                            Browser Anda tidak mendukung iframe.
                        </iframe>
                        
                        
                        <h6 class="mt-4">Peserta Dinas</h6>
                        <table id="pesertaTableDinas" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
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
     

        $(document).ready(function () {
            // Cache for user data to avoid repeated AJAX calls
            let userCache = null;

            function loadUsers() {
                // If data is cached, use it
                if (userCache) {
                    populateDropdowns(userCache);
                    return;
                }

                $.ajax({
                    url: '/user/getAllUser',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        // Sort data by name (if not pre-sorted by server)
                        data.sort((a, b) => a.name.localeCompare(b.name));
                        userCache = data; // Cache the data
                        populateDropdowns(data);
                    },
                    error: function (xhr, status, error) {
                        console.error('Gagal memuat data karyawan:', error);
                        // Provide user feedback
                        const errorOption = '<option value="" disabled selected>Gagal memuat data karyawan</option>';
                        $('#created_by_barang, #created_by_dinas').html(errorOption);
                    }
                });
            }

            function populateDropdowns(data) {
                 console.log("Data karyawan yang akan diisi:", data);
                // Generate structured options for Selectize
                const userOptions = data.map(user => ({
                    value: user.nrp_karyawan,
                    text: `${user.nrp_karyawan} - ${user.name}`
                }));

                // Populate dropdowns with HTML options
                const optionsHtml = ['<option value="" disabled selected>Pilih Karyawan</option>']
                    .concat(data.map(user => `<option value="${user.nrp_karyawan}">${user.nrp_karyawan} - ${user.name}</option>`))
                    .join('');

                $('#created_by_barang').html(optionsHtml);
                $('#created_by_dinas').html(optionsHtml);

                // Destroy existing Selectize instances to prevent memory leaks
                $('.selectize').each(function () {
                    if (this.selectize) {
                        this.selectize.destroy();
                    }
                });

                // Initialize Selectize with structured options
                $('.selectize').selectize({
                    options: userOptions, // Provide structured options
                    valueField: 'value',
                    labelField: 'text',
                    searchField: ['text'],
                    sortField: 'text',
                    placeholder: 'Pilih atau cari Karyawan',
                    // Use Selectize's built-in fuzzy search
                    score: function (search) {
                        const score = this.getScoreFunction(search);
                        return function (item) {
                            return score(item);
                        };
                    }
                });
            }

            // Trigger the load
            loadUsers();
        });


        let globalCalendar;

        // $('#calendarModal').on('show.bs.modal', function() {
        //     $.get(`/kendaraan/booking-dates-all`, function(data) {
        //         const events = data
        //             .filter(item => item.status !== 'Expired' || item.status == 'Level 0')
        //             .map(item => {
        //                 let badgeText = '';
        //                 let color = '';
        //                 switch (item.jenis_kendaraan) {
        //                     case 1:
        //                         color = '#28a745';
        //                         break;
        //                     case 2:
        //                         color = '#007bff';
        //                         break;
        //                     case 3:
        //                         color = '#ffc107';
        //                         break;
        //                     default:
        //                         badgeText = '';
        //                 }

        //                 return {
        //                     title: badgeText + item.merk_kendaraan + ' - ' + item.nomor_kendaraan,
        //                     start: item.tanggal_penggunaan,
        //                     allDay: true,
        //                     backgroundColor: color,
        //                     borderColor: color,
        //                     textColor: '#ffffff',
        //                     extendedProps: {
        //                         merk: item.merk_kendaraan,
        //                         nopol: item.nomor_kendaraan,
        //                         tanggal: item.tanggal_penggunaan,
        //                         id: item.surat_kendaraan_dinas_id,
        //                         status: item.status,
        //                         jenis: item.jenis_kendaraan,
        //                         kapasitas_tersedia: item.kapasitas_tersedia
        //                     }
        //                 };
        //             });

        //         if (globalCalendar) globalCalendar.destroy();

        //         const calendarEl = document.getElementById('calendarAllKendaraan');
        //         globalCalendar = new FullCalendar.Calendar(calendarEl, {
        //             initialView: 'dayGridMonth',
        //             height: 450,
        //             locale: 'id',
        //             events: events,
        //             headerToolbar: {
        //                 left: 'prev,next today',
        //                 center: 'title',
        //                 right: 'dayGridMonth,timeGridWeek,listMonth'
        //             },
        //             eventDidMount: function(info) {
        //                 const kapasitas = info.event.extendedProps.kapasitas_tersedia || 'Tidak diketahui';
        //                 const bgColor = info.event.backgroundColor;

        //                 $(info.el).attr({
        //                     'data-toggle': 'tooltip',
        //                     'data-placement': 'top',
        //                     'title': 'Kapasitas tersedia: ' + kapasitas
        //                 });

        //                 $(info.el).tooltip('dispose');

        //                 $(info.el).tooltip({
        //                     template: `<div class="tooltip bs-tooltip-top" role="tooltip">
        //                                 <div class="arrow"></div>
        //                                 <div class="tooltip-inner" style="background-color: ${bgColor}; color: white;"></div>
        //                             </div>`
        //                 });
        //             },
        //             eventClick: function(info) {
        //                 if (globalCalendar.isProcessing) return;
        //                 globalCalendar.isProcessing = true;

        //                 const event = info.event;
        //                 const suratId = event.extendedProps.id;
        //                 const statusSurat = event.extendedProps.status;

        //                 $('#eventTitle').text(event.title);
        //                 $('#eventDate').text(event.startStr);
        //                 $('#jenisMobil').val('');
        //                 $('#tanggalPakai').val('');
        //                 $('#tujuan_1').val('');
        //                 $('#tujuan_2').val('');
        //                 $('#tujuan_3').val('');
        //                 $('#pesertaTableTambahPeserta tbody').empty();

        //                 $.ajax({
        //                     url: '/pengajuan/infoSuratKendaraanDinasNonAuth',
        //                     type: 'POST',
        //                     data: {
        //                         surat_kendaraan_dinas_id: suratId,
        //                         '_token': '{{ csrf_token() }}'
        //                     },
        //                     dataType: 'json',
        //                     success: function(response) {
        //                         if (response) {
        //                             window.daftarKendaraanGlobal = response.daftar_kendaraan;
        //                             $('#hiddenSuratId').val(suratId);
        //                             $('#nomorSurat').val(suratId);
        //                             const jenisMapping = {
        //                                 1: 'KANTOR',
        //                                 2: 'PRIBADI',
        //                                 3: 'TAXI'
        //                             };
        //                             $('#jenisMobil').val(jenisMapping[response.jenis_kendaraan] || 'TIDAK DIKETAHUI');
        //                             $('#tanggalPakai').val(response.tanggal_penggunaan);
        //                             $('#tujuan_1').val(response.tujuan_penggunaan_1);
        //                             $('#tujuan_2').val(response.tujuan_penggunaan_2);
        //                             $('#tujuan_3').val(response.tujuan_penggunaan_3);

        //                             const pesertaTable = $('#pesertaTableTambahPeserta tbody');
        //                             response.userDinas.forEach((user, index) => {
        //                                 pesertaTable.append(`
        //                                     <tr>
        //                                         <td class="nomor">${index + 1}</td>
        //                                         <td><input type="text" name="peserta[${index}][nrp_karyawan]" class="form-control" value="${user.nrp_karyawan}" readonly></td>
        //                                         <td><input type="text" name="peserta[${index}][nama]" class="form-control" value="${user.name}" readonly></td>
        //                                         <td><input type="text" name="peserta[${index}][departemen]" class="form-control" value="${user.departemen}" readonly></td>
        //                                         <td>
        //                                             <button type="button" class="btn btn-danger btn-sm trash-btn" disabled>
        //                                                 <i class="fas fa-trash"></i>
        //                                             </button>
        //                                         </td>
        //                                     </tr>
        //                                 `);
        //                             });

        //                             const form = $('#editOrderForm');
        //                             if (statusSurat === 'Level 1') {
        //                                 form.find('input, select, textarea').not('[name="_token"]').prop('readonly', true);
        //                                 form.find('select').prop('disabled', true);
        //                                 $('#tambahPesertaBtn').prop('disabled', false);
        //                             } else {
        //                                 form.find('input, select, textarea').not('[name="_token"]').prop('disabled', true);
        //                                 $('#tambahPesertaBtn').prop('disabled', true);
        //                             }

        //                             $('.trash-btn').prop('disabled', true);
        //                             $('#ikutSertaDinasModal').modal('show');
        //                             loadFromLocalStoragePeserta('pesertaTableTambahPeserta', STORAGE_KEY_IKUTSERTA, tambahPesertaIkutSerta);
        //                         }
        //                     },
        //                     error: function() {
        //                         Swal.fire({
        //                             icon: 'error',
        //                             title: 'Gagal Memuat Data',
        //                             text: 'Gagal mengambil data surat kendaraan dinas. Silakan coba lagi.',
        //                             confirmButtonText: 'OK'
        //                         });
        //                     },
        //                     complete: function() {
        //                         globalCalendar.isProcessing = false;
        //                     }
        //                 });
        //             },
        //             dateClick: function(info) {
        //                 const clickedDate = new Date(info.dateStr);
        //                 const today = new Date();
        //                 today.setHours(0, 0, 0, 0);
        //                 clickedDate.setHours(0, 0, 0, 0);

        //                 if (clickedDate <= today) {
        //                     Swal.fire({
        //                         icon: 'warning',
        //                         title: 'Tanggal Tidak Valid',
        //                         text: 'Anda tidak dapat melakukan pemesanan untuk tanggal hari ini atau yang sudah lewat.',
        //                         confirmButtonText: 'OK'
        //                     });
        //                     return;
        //                 }

        //                 $('#tanggal_penggunaan').val(info.dateStr);
        //                 lastFetchedDate = null; // Force API refresh on next toggleJenisKendaraan
        //                 $('#tambahDinasModal').modal('show');
        //                 // Trigger vehicle refresh if jenis_kendaraan is selected
        //                 if (document.getElementById("jenis_kendaraan").value) {
        //                     toggleJenisKendaraan();
        //                 }
        //             }
        //         });

        //         globalCalendar.render();

        //         const currentDate = globalCalendar.getDate();
        //         $('#monthPickerGlobal').val(currentDate.toISOString().slice(0, 7));

        //         $('#monthPickerGlobal').off('change').on('change', function() {
        //             const selected = this.value;
        //             if (selected) {
        //                 const newDate = selected + '-01';
        //                 globalCalendar.gotoDate(newDate);
        //                 // Update tanggal_penggunaan if modal is open
        //                 if ($('#tambahDinasModal').hasClass('show')) {
        //                     $('#tanggal_penggunaan').val(newDate);
        //                     lastFetchedDate = null; // Force API refresh
        //                     if (document.getElementById("jenis_kendaraan").value) {
        //                         toggleJenisKendaraan();
        //                     }
        //                 }
        //             }
        //         });
        //     }).fail(function() {
        //         Swal.fire({
        //             icon: 'error',
        //             title: 'Gagal Memuat Kalender',
        //             text: 'Gagal mengambil data pemesanan kendaraan. Silakan coba lagi.',
        //             confirmButtonText: 'OK'
        //         });
        //     });
        // });
        $('#calendarModal').on('show.bs.modal', function() {
            $.get(`/kendaraan/booking-dates-all`, function(data) {
                const events = data
                    .filter(item => item.status !== 'Expired' || item.status == 'Level 0')
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
                            title: badgeText + item.merk_kendaraan + ' - ' + item.nomor_kendaraan,
                            start: item.tanggal_penggunaan,
                            allDay: true,
                            backgroundColor: color,
                            borderColor: color,
                            textColor: '#ffffff',
                            extendedProps: {
                                merk: item.merk_kendaraan,
                                nopol: item.nomor_kendaraan,
                                tanggal: item.tanggal_penggunaan,
                                surat_ids: item.surat_ids.split(','), // Split the comma-separated surat_ids into an array
                                status: item.status,
                                jenis: item.jenis_kendaraan,
                                kapasitas_tersedia: item.kapasitas_tersedia
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
                        right: 'dayGridMonth,timeGridWeek,listMonth'
                    },
                    eventDidMount: function(info) {
                        const kapasitas = info.event.extendedProps.kapasitas_tersedia || 'Tidak diketahui';
                        const bgColor = info.event.backgroundColor;

                        $(info.el).attr({
                            'data-toggle': 'tooltip',
                            'data-placement': 'top',
                            'title': 'Kapasitas tersedia: ' + kapasitas
                        });

                        $(info.el).tooltip('dispose');

                        $(info.el).tooltip({
                            template: `<div class="tooltip bs-tooltip-top" role="tooltip">
                                        <div class="arrow"></div>
                                        <div class="tooltip-inner" style="background-color: ${bgColor}; color: white;"></div>
                                    </div>`
                        });
                    },
                    eventClick: function(info) {
                        if (globalCalendar.isProcessing) return;
                        globalCalendar.isProcessing = true;

                        const event = info.event;
                        const suratIds = event.extendedProps.surat_ids; // Array of surat_kendaraan_dinas_id
                        const jenisKendaraan = event.extendedProps.jenis;
                        const noPolisi = event.extendedProps.nopol; // Get the license plate number

                        $('#eventTitle').text(event.title);
                        $('#eventDate').text(event.startStr);

                        // Fetch details for all related surat_ids
                        $.ajax({
                            url: '/pengajuan/infoSuratKendaraanDinasNonAuth',
                            type: 'POST',
                            data: {
                                surat_kendaraan_dinas_id: suratIds.join(','), // Send comma-separated surat_ids
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

                                    // Aggregate booking data into a single row
                                    const bookingTableBody = $('#bookingTableBody');
                                    bookingTableBody.empty();
                                    const uniqueBookings = response.reduce((acc, booking) => {
                                        acc.tanggal = booking.tanggal_penggunaan || acc.tanggal || '-';
                                        acc.jenis = jenisMapping[booking.jenis_kendaraan] || acc.jenis || 'TIDAK DIKETAHUI';
                                        acc.tujuan1 = acc.tujuan1 || booking.tujuan_penggunaan_1 || '-';
                                        acc.tujuan2 = acc.tujuan2 || booking.tujuan_penggunaan_2 || '-';
                                        acc.tujuan3 = acc.tujuan3 || booking.tujuan_penggunaan_3 || '-';
                                        return acc;
                                    }, {});
                                    bookingTableBody.append(`
                                        <tr>
                                            <td>1</td>
                                            <td>${noPolisi || '-'}</td>
                                            <td>${uniqueBookings.jenis}</td>
                                            <td>${uniqueBookings.tanggal}</td>
                                            <td>${uniqueBookings.tujuan1}</td>
                                            <td>${uniqueBookings.tujuan2}</td>
                                            <td>${uniqueBookings.tujuan3}</td>
                                        </tr>
                                    `);

                                    // Populate the peserta table with "No Surat" for each participant
                                    const pesertaTableBody = $('#pesertaTableBody');
                                    pesertaTableBody.empty();
                                    let participantIndex = 1;
                                    response.forEach(booking => {
                                        if (booking.userDinas && Array.isArray(booking.userDinas)) {
                                            booking.userDinas.forEach(user => {
                                                pesertaTableBody.append(`
                                                    <tr>
                                                        <td>${participantIndex}</td>
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
                                    confirmButtonText: 'OK'
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

                        if (clickedDate <= today) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Tanggal Tidak Valid',
                                text: 'Anda tidak dapat melakukan pemesanan untuk tanggal hari ini atau yang sudah lewat.',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }

                        $('#tanggal_penggunaan').val(info.dateStr);
                        lastFetchedDate = null; // Force API refresh on next toggleJenisKendaraan
                        $('#tambahDinasModal').modal('show');
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
                            lastFetchedDate = null; // Force API refresh
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
                    confirmButtonText: 'OK'
                });
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
                <td><input type="text" name="barang_ids[]" class="form-control" placeholder="Nama Barang" required autocomplete="off"></td>
                <td><input type="text" name="jumlah[]" class="form-control jumlah-input" placeholder="Jumlah" required autocomplete="off"></td>
                <td>
                    <select name="satuan[]" class="form-control" required>
                        <option value="" disabled selected>Pilih Satuan</option>
                        <option value="unit">Unit</option>
                        <option value="pcs">PCS</option>
                        <option value="kg">KG</option>
                        <option value="jumbo bag">JUMBO BAG</option>
                        <option value="drum">DRUM</option>
                    </select>
                </td>
                <td><input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan" autocomplete="off"></td>
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
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
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
                    confirmButtonText: 'OK'
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
                    <td><input type="text" name="barang_ids[]" class="form-control" value="${item.barang_id}" placeholder="Nama Barang" required autocomplete="off"></td>
                    <td><input type="text" name="jumlah[]" class="form-control jumlah-input" value="${item.jumlah}" placeholder="Jumlah" required autocomplete="off"></td>
                    <td>
                        <select name="satuan[]" class="form-control" required>
                            <option value="" disabled ${item.satuan === '' ? 'selected' : ''}>Pilih Satuan</option>
                            <option value="unit" ${item.satuan === 'unit' ? 'selected' : ''}>Unit</option>
                            <option value="pcs" ${item.satuan === 'pcs' ? 'selected' : ''}>PCS</option>
                            <option value="kg" ${item.satuan === 'kg' ? 'selected' : ''}>KG</option>
                            <option value="jumbo bag" ${item.satuan === 'jumbo bag' ? 'selected' : ''}>JUMBO BAG</option>
                            <option value="drum" ${item.satuan === 'drum' ? 'selected' : ''}>DRUM</option>
                        </select>
                    </td>
                    <td><input type="text" name="keterangan[]" class="form-control" value="${item.keterangan}" placeholder="Keterangan" autocomplete="off"></td>
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
        

        let selectedVehicleCapacity = null;
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
                        confirmButtonText: 'OK'
                    });
                } else if (!jenisKendaraan) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Jenis Kendaraan Belum Dipilih',
                        text: 'Silakan pilih jenis kendaraan terlebih dahulu.',
                        confirmButtonText: 'OK'
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
                                <td><input type="text" name="kendaraan[0][merk_kendaraan]" class="form-control merk_kendaraan" readonly required></td>
                                <td><input type="number" name="kendaraan[0][kapasitas_kendaraan]" class="form-control kapasitas_kendaraan input-kapasitas" min="1" readonly required></td>
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
                            selectizeControl.disable();
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
                                merkField.val(selected.merk_kendaraan).prop('readonly', true);
                                kapasitasField.val(selected.kapasitas_tersedia).prop('readonly', true);
                                selectedVehicleCapacity = parseInt(selected.kapasitas_tersedia) || null;
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
                        confirmButtonText: 'OK'
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
                                    <td>${barangInfo.jumlah_barang}</td>
                                    <td>${barangInfo.satuan_barang}</td>
                                    <td>${barangInfo.keterangan_barang}</td>
                                </tr>
                            `);
                        });
                    } else {
                        tbody.append('<tr><td colspan="5" class="text-center">Tidak ada data barang</td></tr>');
                    }

                    // Inisialisasi ulang DataTable setelah data diisi
                    $('#barangKeluarTable').DataTable({
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
                                    <td>${barang.nama_barang}</td>
                                    <td>${barang.jumlah_barang}</td>
                                    <td>${barang.satuan_barang}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"> ${barang.keterangan_barang}</td>
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
                            return `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.surat_kendaraan_dinas_id}</td>
                                    <td>${item.created_by}</td>
                                    <td>${item.created_date}</td>
                                    <td>${item.tujuan_penggunaan_1 || '-'} ${item.tujuan_penggunaan_2 || ''} ${item.tujuan_penggunaan_3 || ''}</td>
                                    <td>${item.jenis_kendaraan}</td>
                                    <td>${item.tanggal_penggunaan}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" onclick="getQrCodePenggunaanKendaraanDinas('${item.surat_kendaraan_dinas_id}')">
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

                    if (response.userDinas && response.userDinas.length > 0) {
                        $.each(response.userDinas, function(index, userInfo) {
                            tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${userInfo.user?.nrp_karyawan}</td>
                                    <td>${userInfo.user?.name}</td>
                                    <td>${userInfo.user?.departemen}</td>
                                </tr>
                            `);
                        });
                    } else {
                        tbody.append('<tr><td colspan="5" class="text-center">Tidak ada peserta dinas</td></tr>');
                    }

                    // Inisialisasi ulang DataTable setelah data diisi
                    $('#pesertaTableDinas').DataTable({
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
                    if (response.userDinas && response.userDinas.length > 0) {
                        userDinasContent += '<table style="width:100%; border-collapse: collapse;" border="1">';
                        userDinasContent += '<thead><tr>';
                        userDinasContent += '<th>No</th>';
                        userDinasContent += '<th>NRP</th>';
                        userDinasContent += '<th>Nama</th>';
                        userDinasContent += '<th>Departemen</th>';
                        userDinasContent += '</tr></thead><tbody>';
                        response.userDinas.forEach((userItem, index) => {
                            userDinasContent += `<tr>
                                <td>${index + 1}</td>
                                <td>${userItem.nrp_karyawan}</td>
                                <td>${userItem.user?.name}</td>
                                <td>${userItem.user?.departemen}</td>
                            </tr>`;
                        });
                        userDinasContent += '</tbody></table>';
                    } else {
                        userDinasContent = '<p>Tidak ada data peserta dinas.</p>';
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
                    text: `Kapasitas kendaraan adalah ${selectedVehicleCapacity}, hanya ${selectedVehicleCapacity - 1} peserta yang diperbolehkan (termasuk sopir).`,
                    confirmButtonText: 'OK'
                });
                // Remove excess rows
                while (pesertaTable.getElementsByTagName('tr').length > selectedVehicleCapacity - 1) {
                    pesertaTable.deleteRow(-1);
                }
                updateNomorPeserta();
            }
        }

        // Local storage keys for separation
        const STORAGE_KEY_TAMBAH = 'nrp_karyawan_list_tambah';
        const STORAGE_KEY_IKUTSERTA = 'nrp_karyawan_list_ikutserta';

        let counterPeserta = 1;
        let counterIkutserta = 1;

        // Save to local storage for specific table
        function saveToLocalStoragePeserta(tableId, storageKey) {
            const nrpInputs = $(`#${tableId} .nrp_karyawan`);
            const nrpList = Array.from(nrpInputs).map(input => $(input).val()).filter(val => val);
            localStorage.setItem(storageKey, JSON.stringify(nrpList));
        }

        // Load from local storage for specific table
        function loadFromLocalStoragePeserta(tableId, storageKey, addRowFn) {
            const storedList = localStorage.getItem(storageKey);
            if (storedList) {
                const nrpList = JSON.parse(storedList);
                const currentRows = $(`#${tableId} .nrp_karyawan`).length;

                // Add rows if needed
                while (currentRows < nrpList.length) {
                    addRowFn();
                }

                // Populate inputs
                $(`#${tableId} .nrp_karyawan`).each(function(idx) {
                    if (nrpList[idx]) {
                        $(this).val(nrpList[idx]).trigger('keyup');
                    }
                });
            }
        }

        // Clear local storage for specific key
        function clearLocalStorage(storageKey) {
            localStorage.removeItem(storageKey);
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

        // Add participant row for tambahDinasModal
        function tambahComboBoxPeserta() {
            const container = document.querySelector('#pesertaTableTambah tbody');
            const rows = container.querySelectorAll('tr');

            if (!selectedVehicleCapacity) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Kendaraan Terlebih Dahulu',
                    text: 'Silakan pilih kendaraan untuk menentukan kapasitas maksimal peserta.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (rows.length >= selectedVehicleCapacity) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kapasitas Penuh',
                    text: `Kapasitas kendaraan adalah ${selectedVehicleCapacity}, hanya ${selectedVehicleCapacity - 1} peserta yang diperbolehkan (termasuk sopir).`,
                    confirmButtonText: 'OK'
                });
                return;
            }

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="nomor">${++counterPeserta}</td>
                <td><input type="text" name="peserta[${counterPeserta - 1}][nrp_karyawan]" class="form-control nrp_karyawan" placeholder="NRP Karyawan" required autocomplete="off"></td>
                <td><input type="text" name="peserta[${counterPeserta - 1}][nama]" class="form-control nama" placeholder="Nama" readonly></td>
                <td><input type="text" name="peserta[${counterPeserta - 1}][departemen]" class="form-control departemen" placeholder="Departemen" readonly></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBoxPeserta(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            container.appendChild(newRow);
            updateNomorPeserta('pesertaTableTambah');
            saveToLocalStoragePeserta('pesertaTableTambah', STORAGE_KEY_TAMBAH);
        }

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
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
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
                    confirmButtonText: 'OK'
                });
            }
        }

        function tambahPesertaIkutSerta() {
            const tbody = document.querySelector('#pesertaTableTambahPeserta tbody');
            const rows = tbody.querySelectorAll('tr');

            if (rows.length >= 5) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Maksimal 5 Peserta',
                    text: 'Anda hanya bisa menambahkan hingga 5 peserta saja.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="nomor">${++counterIkutserta}</td>
                <td><input type="text" name="peserta[${counterIkutserta - 1}][nrp_karyawan]" class="form-control nrp_karyawan" placeholder="NRP Karyawan" required autocomplete="off"></td>
                <td><input type="text" name="peserta[${counterIkutserta - 1}][nama]" class="form-control nama" placeholder="Nama" readonly></td>
                <td><input type="text" name="peserta[${counterIkutserta - 1}][departemen]" class="form-control departemen" placeholder="Departemen" readonly></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusIkutPeserta(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(newRow);
            updateNomorPeserta('pesertaTableTambahPeserta');
            saveToLocalStoragePeserta('pesertaTableTambahPeserta', STORAGE_KEY_IKUTSERTA);
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
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
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
                    confirmButtonText: 'OK'
                });
            }
        }

        // Handle NRP input and AJAX for user details
        $(document).ready(function() {
            // Sync created_by with first participant
            $('#created_by').on('input', function() {
                const nrp = $(this).val();
                $("input[name='peserta[0][nrp_karyawan]']").val(nrp).trigger('keyup');
            });

            // Handle NRP input changes
            $(document).on('keyup', '.nrp_karyawan', function() {
                const nrp = $(this).val();
                const row = $(this).closest('tr');
                const tableId = row.closest('table').attr('id');
                const storageKey = tableId === 'pesertaTableTambah' ? STORAGE_KEY_TAMBAH : STORAGE_KEY_IKUTSERTA;

                if (nrp.length >= 6) {
                    $.ajax({
                        url: "{{ route('pengajuan_dinas.getUserDetails') }}",
                        type: 'GET',
                        data: { nrp_karyawan: nrp },
                        success: function(response) {
                            if (response.success) {
                                row.find('.nama').val(response.data.name);
                                row.find('.departemen').val(response.data.departemen);
                            } else {
                                row.find('.nama').val('');
                                row.find('.departemen').val('');
                            }
                            saveToLocalStoragePeserta(tableId, storageKey);
                        },
                        error: function() {
                            row.find('.nama').val('');
                            row.find('.departemen').val('');
                            saveToLocalStoragePeserta(tableId, storageKey);
                        }
                    });
                } else {
                    row.find('.nama').val('');
                    row.find('.departemen').val('');
                    saveToLocalStoragePeserta(tableId, storageKey);
                }
            });

            // Load stored data on page load
            loadFromLocalStoragePeserta('pesertaTableTambah', STORAGE_KEY_TAMBAH, tambahComboBoxPeserta);
            loadFromLocalStoragePeserta('pesertaTableTambahPeserta', STORAGE_KEY_IKUTSERTA, tambahPesertaIkutSerta);

            // Clear local storage on form submission
            $('#tambah_penggunaan_kendaraan_dinas').on('submit', function() {
                clearLocalStorage(STORAGE_KEY_TAMBAH);
            });

            $('#editOrderForm').on('submit', function() {
                clearLocalStorage(STORAGE_KEY_IKUTSERTA);
            });
        });


        document.addEventListener("DOMContentLoaded", function () {
            const inputKm = document.getElementById("kilometer_awal");

            inputKm.addEventListener("input", function (e) {
                let value = this.value.replace(/\D/g, ''); // hanya angka
                this.value = formatRibuan(value);
            });

            function formatRibuan(angka) {
                return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
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



