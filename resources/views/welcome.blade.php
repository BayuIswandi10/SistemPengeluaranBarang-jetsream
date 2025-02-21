
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

        <!-- Modal Approval -->
        <div class="modal fade" id="editApprovalModal" tabindex="-1" aria-labelledby="editApprovalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="editApprovalLabel">Pemeriksaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editApprovalForm">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="row mb-3">
                                        <label for="pengeluaranBarangId" class="col-sm-4 col-form-label">No. Pengeluaran</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="pengeluaranBarangId" name="pengeluaranBarangId" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="tujuan" class="col-sm-4 col-form-label">Tujuan</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="tujuan" name="tujuan" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="jenisKendaraan" class="col-sm-4 col-form-label">Jenis Kendaraan</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="jenisKendaraan" name="jenisKendaraan" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="noPolisi" class="col-sm-4 col-form-label">No. Polisi</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="noPolisi" name="noPolisi">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div id="qrcodeContainer" style="border: 1px solid #ddd; padding: 10px; text-align: center;">
                                        <!-- QR Code akan diisi oleh JavaScript -->
                                        <img src="path/to/qrcode.png" alt="QR Code" id="qrcode" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                        </form>

                        <iframe hidden id="qrFrame" width="500" height="400" srcdoc="">
                            Browser Anda tidak mendukung iframe.
                        </iframe>
                        
                        
                        <h6 class="mt-4">Detail Barang</h6>
                        <table id="barangTableApproval" class="table table-striped table-bordered">
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
                        <form action="{{ route('approval.updateStatusSecurity') }}" method="POST" id="approvalForm">
                            @csrf
                            @method('POST')
                            <button type="button" class="btn btn-success" onclick="saveApproval()">Setujui</button>
                        </form>
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="btnPrintQR" onclick="printIframe()">Cetak QR Code</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        function printIframe() {
            var iframe = document.getElementById('qrFrame');
            iframe.contentWindow.print(); // Cetak isi dalam iframe
        }

        function printQRCode() {
            var originalContent = document.body.innerHTML;
            var qrCodeContent = document.getElementById("qrcodeContainer").innerHTML;

            // Tampilkan hanya QR Code
            document.body.innerHTML = qrCodeContent;

            window.print();

            // Kembalikan tampilan asli setelah pencetakan
            document.body.innerHTML = originalContent;
        }
        let counter = 1;

        function tambahComboBox() {
            const container = document.getElementById('barangTableTambah');
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
            const container = document.getElementById('barangTableTambah');
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
        const rows = document.querySelectorAll('#barangTableTambah .nomor');
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
                                        <button type="button" class="btn btn-${item.status === 'Level 4' ? 'success' : 'primary'} btn-sm" onclick="editApproval('${item.pengeluaran_barang_id}')">
                                            <i class="fas ${item.status === 'Level 4' ? 'fa-edit' : 'fa-info-circle'}"></i>
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
        function editApproval(pengeluaranBarangId) {
            $.ajax({
                url: "{{ route('pengeluaran.edit') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    pengeluaran_barang_id: pengeluaranBarangId
                },
                success: function(response) {
                    $('#btnPrintQR').hide();

                    //gunakan untuk membuat input field menjadi read only
                    if (response.no_polisi) {
                        $('#btnPrintQR').show();
                        $('#noPolisi').val(response.no_polisi).prop('readonly', true);
                        $('#btnSaveApproval').prop('disabled', true);
                    } else {
                        $('#noPolisi').val('').prop('readonly', false);
                        $('#btnSaveApproval').prop('disabled', false);
                    }

                    // Isi field pada modal
                    $('#pengeluaranBarangId').val(response.pengeluaran_barang_id);
                    $('#tujuan').val(response.tujuan_pengeluaran_barang);
                    $('#jenisKendaraan').val(response.jenis_kendaraan);

                    // Cek apakah No Polisi sudah ada, jika ada maka disable inputnya
                    if (response.no_polisi) {
                        $('#noPolisi').val(response.no_polisi).prop('disabled', true);
                        $('#btnSaveApproval').prop('disabled', true);
                    } else {
                        $('#noPolisi').val('').prop('disabled', false);
                        $('#btnSaveApproval').prop('disabled', false);
                    }

                    // Sembunyikan tombol "Setujui" jika status Level 5
                    if (response.status === 'Level 5') {
                        $('#btnSaveApproval').hide();
                    } else {
                        $('#btnSaveApproval').show();
                    }

                    // Nonaktifkan input yang tidak perlu diubah
                    $('#pengeluaranBarangId, #tujuan, #jenisKendaraan').prop('disabled', true);

                    // Inisialisasi DataTable
                    let table = $('#barangTableApproval').DataTable();
                    
                    // Hancurkan DataTable jika sudah ada agar tidak menumpuk data lama
                    if ($.fn.DataTable.isDataTable('#barangTableApproval')) {
                        table.destroy();
                    }

                    // Kosongkan isi tabel
                    let tbody = $('#barangTableApproval tbody');
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
                    $('#barangTableApproval').DataTable({
                        responsive: true,
                        autoWidth: false,
                        scrollX: false,
                        destroy: true,
                        retrieve: true,
                        pageLength: 5, // Menampilkan 5 data per halaman
                        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]] // Pilihan jumlah data per halaman
                    });

                    // Update container QR Code dengan output dari BaconQrCode
                    $('#qrcodeContainer').html(response.qr_code);

                    // Buat konten barang keluar untuk ditampilkan di dalam iframe
                    let barangContent = '';
                    if (response.barangKeluar && response.barangKeluar.length > 0) {
                        barangContent += '<table style="width:100%; border-collapse: collapse;" border="1">';
                        barangContent += '<thead><tr>';
                        barangContent += '<th>No</th>';
                        barangContent += '<th>Nama Barang</th>';
                        barangContent += '<th>Jumlah</th>';
                        barangContent += '<th>Satuan</th>';
                        barangContent += '<th>Keterangan</th>';
                        barangContent += '</tr></thead><tbody>';
                        response.barangKeluar.forEach((barang, index) => {
                            barangContent += `<tr>
                                <td>${index + 1}</td>
                                <td>${barang.nama_barang}</td>
                                <td>${barang.jumlah_barang}</td>
                                <td>${barang.satuan_barang}</td>
                                <td>${barang.keterangan_barang}</td>
                            </tr>`;
                        });
                        barangContent += '</tbody></table>';
                    } else {
                        barangContent = '<p>Tidak ada data barang keluar.</p>';
                    }
                    // Perbarui isi srcdoc pada iframe dengan data terbaru
                    let iframeContent = `
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
                                        <div class="box">${response.qr_code}</div>
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
                    $('#qrFrame').attr('srcdoc', iframeContent).prop('hidden', true);

                    // Tampilkan modal edit approval
                    $('#editApprovalModal').modal('show');
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

        function saveApproval() {
            var pengeluaranBarangId = document.getElementById('pengeluaranBarangId').value;
            var noPolisi = document.getElementById('noPolisi').value;

            // Konfirmasi dengan Swal sebelum melakukan update
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Setujui pengeluaran ini?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setuju!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim data ke server menggunakan AJAX untuk memperbarui pengeluaran barang dan approval
                    $.ajax({
                        url: "{{ route('approval.updateNopolisi') }}",  // Ganti dengan route yang sesuai
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",  // CSRF token untuk keamanan
                            pengeluaran_barang_id: pengeluaranBarangId,
                            no_polisi: noPolisi
                        },
                        success: function(response) {
                            if (response.success) {
                                // Tampilkan pesan sukses
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    // Reload halaman setelah sukses
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan!',
                                text: 'Error: ' + error,
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    });
                }
            });
        }



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



