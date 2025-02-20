
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
                            <div class="col-lg-6 col-md-6 mt-5 mt-md-0 text-center">
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

        <!-- Modal -->
        <div class="modal fade" id="modalPengajuan" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false">
            <div class="modal-dialog modal-xl" role="document">
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

        $(document).ready(function () {  

            // Event untuk menangani klik elemen dengan id modalPengajuan
            $('#modalPengajuanTrigger').on('click', function () {
                $('#modalPengajuan').modal('show');
                loadTableData();

            });

            function loadTableData() {
                $.ajax({
                    url: "/pengeluaran/get-data-level5",
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
                                        <i class="fas fa-print text-primary" 
                                            style="cursor: pointer; font-size: 16px;" 
                                            onclick="printIframe()" 
                                            data-nomor="${item.pengeluaran_barang_id}">
                                        </i>
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



