
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

       <!-- Grafis Section -->
        <div class="hero-section">
            <div class="text-container">
                <div class="text-center text-white">
                    <h1 class="display-4 mt-3 font-weight-bold">Digital Logistic Transport Permit</h1>
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
                                    <p class="lead">Mengoptimalkan Penggunaan Kendaraan Dinas</p>
                                </div>
                                <div class="carousel-item">
                                    <p class="lead">Meningkatkan Transparansi</p>
                                </div>
                                <div class="carousel-item">
                                    <p class="lead">Mengurangi Kesalahan Data</p>
                                </div>
                                <div class="carousel-item">
                                    <p class="lead">Meningkatkan Kecepatan dan Efisiensi Operasional</p>
                                </div>
                                <div class="carousel-item">
                                    <p class="lead">Notifikasi via Email Secara Realtime</p>
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
            <div class="rounded shadow p-5 bg-white">
                <div class="row">
                    <!-- Card 1: Efisiensi Administrasi -->
                    <div class="col-lg-3 col-md-6 mt-5 mt-md-0 text-center card-hover">
                        <i class="fas fa-tasks text-primary h1"></i>
                        <h3 class="mt-4 text-capitalize h5">Efisiensi Administrasi</h3>
                        <p class="regular text-muted">Sistem digital untuk mempercepat dan mempermudah administrasi.</p>
                    </div>
                    <!-- Card 2: Pengelolaan Barang -->
                    <div class="col-lg-3 col-md-6 mt-5 mt-md-0 text-center card-hover">
                        <i class="fas fa-box text-primary h1"></i>
                        <h3 class="mt-4 text-capitalize h5">Pengelolaan Barang</h3>
                        <p class="regular text-muted">Pelacakan dan pengelolaan barang secara akurat dan terstruktur.</p>
                    </div>
                    <!-- Card 3: Pengelolaan Kendaraan Dinas -->
                    <div class="col-lg-3 col-md-6 mt-5 mt-lg-0 text-center card-hover">
                        <i class="fas fa-car text-primary h1"></i>
                        <h3 class="mt-4 text-capitalize h5">Kendaraan Dinas</h3>
                        <p class="regular text-muted">Pengajuan dan pemantauan kendaraan dinas yang lebih mudah.</p>
                    </div>
                    <!-- Card 4: Notifikasi Realtime -->
                    <div class="col-lg-3 col-md-6 mt-5 mt-lg-0 text-center card-hover">
                        <i class="fas fa-bell text-primary h1"></i>
                        <h3 class="mt-4 text-capitalize h5">Notifikasi Realtime</h3>
                        <p class="regular text-muted">Pemberitahuan langsung untuk memastikan proses berjalan lancar.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



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
    
</x-guest-layout>



