<x-guest-layout>
  <head>
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
        </style>    
        
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
  </head>

  <body>
    <div class="nav-static-top d-flex justify-content-between align-items-center p-3 bg-light">
        <div class="float-left">
            <a href="#">
                <img class="mt-3 ml-4" src="{{ asset('assets/img/logo-YMI-DLTP.png') }}" style="height:80px;">
            </a>
        </div>
    </div>

    <div class="login-box">
        <div class="card card-outline card-primary login-card">
            <div class="card-body">
                <video id="preview"></video>
                <div class="form-area mt-3 d-flex">
                    <input type="text" id="scanResult" class="form-control me-2 custom-input" placeholder="Scan QR-Code atau Ketik No Surat" autocomplete="off">
                    <button id="btnCari" class="btn btn-primary" type="button">Cari</button>
                </div>
            </div>
            
            <div class="card-footer d-flex justify-content-center">
               <a href="{{ url('/') }}">
                    <button type="button" class="btn btn-secondary mr-2">
                        {{ __('Kembali') }}
                    <button>
                </a>
            </div>
        </div>
        <audio id="beep" src="{{ asset('assets/sound/beep-sound-8333.mp3') }}" autostart="false"></audio>
    </div>

    <!--Detail Pengeluaran Barang -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" id="modalHeader" style="position: relative;">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h5 class="modal-title" id="detailModalLabel">Detail Barang Keluar</h5>
                    </div>
                    <div style="position: absolute; right: 50px; top: 50%; transform: translateY(-50%); display: flex; align-items: center; gap: 10px;">
                        <i id="statusIcon" style="font-size: 1.8rem; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;"></i>
                    </div>
                    <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p><strong>Nomor Polisi:</strong> <span id="nomorPolisiCard"></span></p>
                    </div>
                    <!-- Card untuk Tabel Barang Keluar -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Informasi Barang Keluar</h6>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">No</th>
                                        <th>Nomor Pengeluaran Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="detailBody">
                                    <!-- Data akan diisi secara dinamis -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <!-- Card untuk Tabel Informasi Tambahan -->
                    <div class="card mt-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Informasi Historis Persetujuan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="additionalInfoTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">No</th>
                                        <th>Nama</th>
                                        <th>Tingkatan</th>
                                        <th>Departemen</th>
                                        <th>Status Persetujuan</th>
                                        <th>Tanggal Persetujuan</th>
                                        <th>Alasan</th>
                                    </tr>
                                </thead>
                                <tbody id="additionalInfoBody">
                                    <!-- Data akan diisi secara dinamis -->
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>  
            </div>
        </div>
    </div>

    {{-- Detail Dinas --}}
    <div class="modal fade" id="suratDinasModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" id="modalHeaderKendaraan" style="position: relative;">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h5 class="modal-title" id="detailModalLabel">Detail Surat Dinas</h5>
                    </div>
                    <i id="statusIconKendaraan" style="position: absolute; right: 50px; top: 50%; transform: translateY(-50%); font-size: 1.8rem; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;"></i>
                    <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p><strong>Nomor Surat:</strong> <span id="nomorSuratCard"></span></p>    
                    </div>
    
                    <!-- Card untuk Tabel Informasi Kendaraan -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Informasi Kendaraan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="kendaraanInfoTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">No</th>
                                        <th>No Kendaraan</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Penggunaan</th>
                                        <th>Rute 1</th>
                                        <th>Rute 2</th>
                                        <th>Rute 3</th>
                                        <th>Keperluan</th>
                                    </tr>
                                </thead>
                                <tbody id="kendaraanInfoBody">
                                    <!-- Data akan diisi secara dinamis -->
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
    
                    <!-- Card untuk Peserta Kendaraan Dinas -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Informasi Peserta</h6>
                        </div>
                        <div class="card-body">
                            <table id="detaildataTableModal" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">No</th>
                                        <th>Nrp Peserta</th>
                                        <th>Nama Peserta</th>
                                        <th>Departemen</th>
                                    </tr>
                                </thead>
                                <tbody id="detailBody">
                                    <!-- Data akan diisi secara dinamis -->
                                </tbody>
                            </table>
                        </div>
                    </div>
    
                    <hr>
    
                    <!-- Card untuk Tabel Informasi Tambahan -->
                    <div class="card mt-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Informasi Historis Persetujuan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="additionalInfoTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">No</th>
                                        <th>Nama</th>
                                        <th>Tingkatan</th>
                                        <th>Departemen</th>
                                        <th>Status Persetujuan</th>
                                        <th>Tanggal Persetujuan</th>
                                        <th>Alasan</th>
                                    </tr>
                                </thead>
                                <tbody id="addhistory">
                                    <!-- Data akan diisi secara dinamis -->
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button id="cetakBukti" type="button" class="btn btn-primary" onclick="printSuratDinas()">Print Surat Dinas</button>
                </div>    
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', () => {
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            const kendaraanPrefixes = ["KN", "PR", "TX"];
            scanner.addListener('scan', function (content) {
                document.getElementById('scanResult').value = content;
                document.getElementById('beep').play();

                const prefix = content.split('/')[0];

                if (kendaraanPrefixes.includes(prefix)) {
                    fetchDetailKendaraan(content);
                } else {
                    fetchDetailPengeluaran(content);
                }
            });

            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (e) {
                console.error(e);
            });

            function fetchDetailPengeluaran(nomor) {
                $('.modal').modal('hide');

                 $.ajax({
                        url: "/pengeluaran/detailNonAuth",
                        method: "POST",
                        data: { pengeluaran_barang_id: nomor, "_token": "{{ csrf_token() }}" },
                        success: function (data) {
                            // Set judul modal berdasarkan kategori
                            const kategoriText = data.kategori_pengeluaran === 1 ? 'Scrap' : 'Non Scrap';
                            document.getElementById('detailModalLabel').innerText = `Detail Barang Keluar Kategori ${kategoriText}`;

                            // Warna header dan ikon berdasarkan status persetujuan
                            const modalHeader = document.getElementById('modalHeader');
                            const statusIcon = document.getElementById('statusIcon');
                            const maxLevel = Math.max(...(data.informasi_tambahan ?? []).map(x => parseInt(x.status?.replace('Level ', '')) || 0));
                            const adaYangMenolak = (data.informasi_tambahan ?? []).some(x => x.status === 'Level 0');
                            
                            if (adaYangMenolak) {
                                // Status DITOLAK
                                modalHeader.style.backgroundColor = '#dc3545';
                                modalHeader.style.color = 'white';
                                statusIcon.className = 'fas fa-times-circle';
                                statusIcon.style.color = 'white';
                                statusIcon.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
                            } else if (
                                (data.kategori_pengeluaran === 1 && maxLevel >= 5) || 
                                (data.kategori_pengeluaran === 0 && maxLevel >= 4)
                            ) {
                                // Status LENGKAP
                                modalHeader.style.backgroundColor = '#28a745';
                                modalHeader.style.color = 'white';
                                statusIcon.className = 'fas fa-clipboard-check';
                                statusIcon.style.color = 'white';
                                statusIcon.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
                            } else {
                                // Status BELUM LENGKAP
                                modalHeader.style.backgroundColor = '#ffe107';
                                modalHeader.style.color = 'black';
                                statusIcon.className = 'fas fa-exclamation-circle';
                                statusIcon.style.color = 'black';
                                statusIcon.style.backgroundColor = 'rgba(0, 0, 0, 0.1)';
                            }

                            document.getElementById('nomorPolisiCard').innerText = data.no_polisi || '-';
                            const tbody = document.getElementById('detailBody');
                            const additionalInfoBody = document.getElementById('additionalInfoBody');
                            
                            tbody.innerHTML = '';
                            additionalInfoBody.innerHTML = '';

                            // Hapus DataTable sebelum menambahkan data baru
                            if ($.fn.DataTable.isDataTable('#dataTable')) {
                                $('#dataTable').DataTable().clear().destroy();
                            }

                            let statusPengeluaran = data.status;
                            let kategoriPengeluaran = data.kategori_pengeluaran;
                            let nomorPolisi = data.no_polisi;
                            
                            // Menambahkan data ke tabel barang keluar
                            if (data.barang_keluar && data.barang_keluar.length > 0) {
                                tbody.innerHTML = data.barang_keluar.map((item, index) => `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${nomor}</td>
                                        <td>${item.nama_barang}</td>
                                        <td>${Number(item.jumlah_barang).toLocaleString('id-ID')}</td>
                                        <td>${item.satuan_barang}</td>
                                        <td>${item.keterangan_barang ?? '-'}</td>
                                    </tr>
                                `).join('');
                            } else {
                                tbody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data barang keluar</td></tr>';
                            }

                            // Mapping tingkatan dan status persetujuan
                            const tingkatMapping = {
                                "Level 1": "Civitas",
                                "Level 2": "PIC/Ka.Sie",
                                "Level 3": "Ka.Dept.Ybs",
                                "Level 4": "Ka.Dept.GA",
                                "Level 5": "Finance",
                                "Level 6": "Security"
                            };
                            const approvMapping = {
                                "Level 0": "Menolak",
                                "Level 1": "Mengajukan",
                                "Level 2": "Menyetujui",
                                "Level 3": "Menyetujui",
                                "Level 4": "Menyetujui",
                                "Level 5": "Menyetujui",
                                "Level 6": "Menyetujui"
                            };
                            
                            // Menambahkan data ke tabel informasi tambahan
                            if (data.informasi_tambahan && data.informasi_tambahan.length > 0) {
                                data.informasi_tambahan.forEach((info, index) => {
                                    let alasanPenolakan = (index === data.informasi_tambahan.length - 1) 
                                        ? info.alasan_penolakan 
                                        : '-';
                                    let row = `
                                        <tr>
                                            <td style="text-align: center">${index + 1}</td>
                                            <td>${info.nama}</td>
                                            <td>${tingkatMapping[info.tingkatan] || info.tingkatan}</td>
                                            <td>${info.departemen}</td>
                                            <td>${approvMapping[info.status] || info.status}</td>
                                            <td style="text-align: right">${info.created_date}</td>
                                            <td>${alasanPenolakan}</td>
                                        </tr>
                                    `;
                                    additionalInfoBody.innerHTML += row;
                                });
                            } else {
                                additionalInfoBody.innerHTML = '<tr><td colspan="5" class="text-center">Tidak ada informasi tambahan</td></tr>';
                            }
                            
                            // Aktifkan DataTable setelah data ditambahkan
                            $('#dataTable').DataTable({
                                columnDefs: [
                                    { className: 'dt-head-center', targets: 0 },
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
                                scrollX: false,
                                destroy: true,
                                pageLength: 5,
                                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                            }); 
                            
                            $('#detailModal').modal('show');
                        },
                        error: function (xhr, status, error) {
                            console.error("Error fetching data:", error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal mengambil data pengeluaran.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });

            }
            // Tambahkan event listener ke tombol "Cari"
            document.getElementById('btnCari').addEventListener('click', function () {
                let barcodeValue = document.getElementById('scanResult').value;
                if (barcodeValue !== "") {
                    const kendaraanPrefixes = ["KN", "PR", "TX"];
                    const prefix = barcodeValue.split('/')[0];

                    if (kendaraanPrefixes.includes(prefix)) {
                        fetchDetailKendaraan(barcodeValue);
                    } else {
                        fetchDetailPengeluaran(barcodeValue);
                    }
                } else {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Nomor tidak boleh kosong!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Biarkan pengguna menekan "Enter" untuk melakukan pencarian
            document.getElementById('scanResult').addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    let barcodeValue = document.getElementById('scanResult').value;
                    if (barcodeValue !== "") {
                        const kendaraanPrefixes = ["KN", "PR", "TX"];
                        const prefix = barcodeValue.split('/')[0];

                        if (kendaraanPrefixes.includes(prefix)) {
                            fetchDetailKendaraan(barcodeValue);
                        } else {
                            fetchDetailPengeluaran(barcodeValue);
                        }
                    } else {
                        Swal.fire({
                            title: 'Peringatan!',
                            text: 'Nomor tidak boleh kosong!',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });

        });

        function fetchDetailKendaraan(nomor) {
            
            $('.modal').modal('hide');
               document.getElementById('nomorSuratCard').innerText = nomor;
            $.ajax({
                url: "/pengajuan/detailSuratNonAuth",
                method: "POST",
                data: { surat_kendaraan_dinas_id: nomor, "_token": "{{ csrf_token() }}" },
                success: function (data) {
                    const detailTable = $('#detaildataTableModal').DataTable();
                    const modalHeader = document.getElementById('modalHeaderKendaraan');
                    const statusIcon = document.getElementById('statusIconKendaraan');

                    const jenisKendraan = {
                        1: "Mengeluarkan"
                    };

                    const informasiTambahan = data.informasi_tambahan ?? [];

                    // Cek apakah ada yang menolak
                    const adaYangMenolak = informasiTambahan.some(x => x.status === 'Level 0');

                    // Cek level tertinggi yang menyetujui
                    const maxLevel = Math.max(...informasiTambahan.map(x => parseInt(x.status?.replace('Level ', '')) || 0));

                    // Set header color and status icon
                    if (adaYangMenolak) {
                        // Status DITOLAK
                        modalHeader.style.backgroundColor = '#dc3545';
                        modalHeader.style.color = 'white';
                        statusIcon.className = 'fas fa-times-circle';
                        statusIcon.style.color = 'white';
                        statusIcon.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
                    } else if (maxLevel >= 3) {
                        // Status LENGKAP
                        modalHeader.style.backgroundColor = '#28a745';
                        modalHeader.style.color = 'white';
                        statusIcon.className = 'fas fa-clipboard-check';
                        statusIcon.style.color = 'white';
                        statusIcon.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
                    } else {
                        // Status BELUM LENGKAP
                        modalHeader.style.backgroundColor = '#ffc107';
                        modalHeader.style.color = 'black';
                        statusIcon.className = 'fas fa-exclamation-circle';
                        statusIcon.style.color = 'black';
                        statusIcon.style.backgroundColor = 'rgba(0, 0, 0, 0.1)';
                    }

                    // Logika tampil/sembunyikan tombol
                    const tombolCetak = document.getElementById('cetakBukti');
                    if (tombolCetak) {
                        if (adaYangMenolak || maxLevel < 3) {
                            tombolCetak.style.display = "none";
                        } else {
                            tombolCetak.style.display = "inline-block";
                        }
                    }

                    // Kosongkan data lama kendaraan
                    document.getElementById('kendaraanInfoBody').innerHTML = "";

                    if ($.fn.DataTable.isDataTable('#detaildataTableModal')) {
                        $('#detaildataTableModal').DataTable().clear().destroy();
                    }

                    // Simpan kilometer awal dan akhir untuk print
                    let kilometerAwal = data.kilometer_awal || '-';
                    let kilometerAkhir = data.kilometer_akhir || '-';
                    let hasPrivateVehicle = data.has_private_vehicle || false;
                    let waktuPergi = data.waktu_pergi || '-';
                    let waktuPulang = data.estimasi_waktu_kembali || '-';

                    // Validasi dan tampilkan data kendaraan
                    if (data.data_kendaraan && data.data_kendaraan.length > 0) {
                        data.data_kendaraan.forEach((item, index) => {
                            let row = `
                                <tr>
                                    <td style="text-align: center">${index + 1}</td>
                                    <td>${item.nomor_kendaraan}</td>
                                    <td>${item.keterangan}</td>
                                    <td style="text-align: right">${item.tanggal_penggunaan || '-'}</td>
                                    <td>${item.tujuan_penggunaan_1 || '-'}</td>
                                    <td>${item.tujuan_penggunaan_2 || '-'}</td>
                                    <td>${item.tujuan_penggunaan_3 || '-'}</td>
                                    <td>${item.alasan_penggunaan || '-'}</td>
                                </tr>
                            `;
                            document.getElementById('kendaraanInfoBody').innerHTML += row;
                        });

                        // Simpan kilometer data untuk print
                        let kilometerElement = document.getElementById('kilometerData');
                        if (!kilometerElement) {
                            kilometerElement = document.createElement('div');
                            kilometerElement.id = 'kilometerData';
                            kilometerElement.style.display = 'none';
                            document.body.appendChild(kilometerElement);
                        }
                        kilometerElement.setAttribute('data-kilometer-awal', kilometerAwal);
                        kilometerElement.setAttribute('data-kilometer-akhir', kilometerAkhir);
                        kilometerElement.setAttribute('data-has-private-vehicle', hasPrivateVehicle);
                        kilometerElement.setAttribute('data-waktu-pergi', waktuPergi);
                        kilometerElement.setAttribute('data-waktu-pulang', waktuPulang);

                    } else {
                        document.getElementById('kendaraanInfoBody').innerHTML = `
                            <tr><td colspan="7" class="text-center">Tidak ada data kendaraan</td></tr>
                        `;
                    }

                    // Kosongkan data lama
                    detailTable.clear();
                    document.getElementById('addhistory').innerHTML = "";

                    // Validasi data userDinas
                    if (data.userDinas && data.userDinas.length > 0) {
                        let newData = data.userDinas.map((item, index) => [
                            index + 1,
                            item.nrp_karyawan,
                            item.name,
                            item.departemen
                        ]);
                        detailTable.rows.add(newData).draw();
                    } else {
                        detailTable.rows.add([["", "", "Tidak ada data user", ""]]).draw();
                    }

                    // Mapping tingkatan dan status persetujuan
                    const tingkatMapping = {
                        "Level 1": "Civitas",
                        "Level 2": "PIC/Ka.Sie",
                        "Level 3": "Ka.Dept.Ybs",
                        "Level 4": "Ka.Dept.GA",
                        "Level 5": "Finance",
                        "Level 6": "Security"
                    };
                    const approvMapping = {
                        "Level 0": "Menolak",
                        "Level 1": "Mengajukan",
                        "Level 2": "Menyetujui",
                        "Level 3": "Menyetujui",
                        "Level 4": "Menyetujui"
                    };

                    // Validasi data informasi_tambahan
                    const additionalInfoBody = document.getElementById('addhistory');

                    if (data.informasi_tambahan && data.informasi_tambahan.length > 0) {
                        data.informasi_tambahan.forEach((info, index) => {
                            let alasanPenolakan = (index === data.informasi_tambahan.length - 1)
                                ? info.alasan_penolakan
                                : '-'; // hanya isi di baris terakhir

                            let row = `
                                <tr>
                                    <td style="text-align: center">${index + 1}</td>
                                    <td>${info.nama}</td>
                                    <td>${tingkatMapping[info.tingkatan] || info.tingkatan}</td>
                                    <td>${info.departemen}</td>
                                    <td>${approvMapping[info.status] || info.status}</td>
                                    <td style="text-align: right">${info.created_date}</td>
                                    <td>${alasanPenolakan}</td>
                                </tr>
                            `;
                            additionalInfoBody.innerHTML += row;
                        });
                    } else {
                        additionalInfoBody.innerHTML = `
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada informasi tambahan</td>
                            </tr>
                        `;
                    }

                    // Aktifkan DataTable setelah data ditambahkan
                    $('#detaildataTableModal').DataTable({
                        columnDefs: [
                            { className: 'dt-body-center dt-head-center', targets: 0 },
                            { className: 'dt-head-center', targets: 1 },
                            { className: 'dt-body-left', targets: 1 }
                        ],
                        responsive: true,
                        scrollX: false,
                        destroy: true,
                        pageLength: 5,
                        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                    });

                    // Pastikan modal terbuka setelah data dimuat
                    $('#suratDinasModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data:", error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal mengambil data surat dinas.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        function printSuratDinas() {
            // Ambil data dari modal
            const nomorSurat = document.getElementById('nomorSuratCard').innerText;

            // Ambil data kendaraan
            let kendaraanRows = '';
            const kilometerElement = document.getElementById('kilometerData');
            const hasPrivateVehicle = kilometerElement ? kilometerElement.getAttribute('data-has-private-vehicle') === 'true' : false;
            const kilometerAwal = kilometerElement ? kilometerElement.getAttribute('data-kilometer-awal') || '-' : '-';
            const kilometerAkhir = kilometerElement ? kilometerElement.getAttribute('data-kilometer-akhir') || '-' : '-';
            const waktuPergi = kilometerElement ? kilometerElement.getAttribute('data-waktu-pergi') || '-' : '-';
            const waktuPulang = kilometerElement ? kilometerElement.getAttribute('data-waktu-pulang') || '-' : '-';


            const kendaraanTable = document.getElementById('kendaraanInfoBody');
            if (kendaraanTable) {
                const rows = kendaraanTable.querySelectorAll('tr');
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    if (cells.length > 0) {
                        kendaraanRows += `
                            <tr>
                                <td style="border: 1px solid #000; padding: 8px; text-align: center;">${cells[0].innerText}</td>
                                <td style="border: 1px solid #000; padding: 8px;">${cells[1].innerText}</td>
                                <td style="border: 1px solid #000; padding: 8px;">${cells[2].innerText}</td>
                                <td style="border: 1px solid #000; padding: 8px; text-align: right;">${cells[3].innerText}</td>
                                <td style="border: 1px solid #000; padding: 8px;">${cells[4].innerText}</td>
                                <td style="border: 1px solid #000; padding: 8px;">${cells[5].innerText}</td>
                                <td style="border: 1px solid #000; padding: 8px;">${cells[6].innerText}</td>
                            </tr>
                        `;
                    }
                });
            }

            // Ambil data peserta dari DataTable
            let pesertaRows = '';
            if ($.fn.DataTable.isDataTable('#detaildataTableModal')) {
                const dataTable = $('#detaildataTableModal').DataTable();
                const data = dataTable.rows({ page: 'all' }).data();
                for (let i = 0; i < data.length; i++) {
                    const rowData = data[i];
                    if (rowData && rowData.length >= 4) {
                        pesertaRows += `
                            <tr>
                                <td style="border: 1px solid #000; padding: 8px; text-align: center;">${rowData[0] || '-'}</td>
                                <td style="border: 1px solid #000; padding: 8px;">${rowData[1] || '-'}</td>
                                <td style="border: 1px solid #000; padding: 8px;">${rowData[2] || '-'}</td>
                                <td style="border: 1px solid #000; padding: 8px;">${rowData[3] || '-'}</td>
                            </tr>
                        `;
                    }
                }
            } else {
                const pesertaTable = document.getElementById('detailBody');
                if (pesertaTable) {
                    const rows = pesertaTable.querySelectorAll('tr');
                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        if (cells.length >= 4 && cells[0].innerText.trim() !== '') {
                            pesertaRows += `
                                <tr>
                                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">${cells[0].innerText}</td>
                                    <td style="border: 1px solid #000; padding: 8px;">${cells[1].innerText}</td>
                                    <td style="border: 1px solid #000; padding: 8px;">${cells[2].innerText}</td>
                                    <td style="border: 1px solid #000; padding: 8px;">${cells[3].innerText}</td>
                                </tr>
                            `;
                        }
                    });
                }
            }

            // Ambil data historis persetujuan
            let historyRows = '';
            const historyTable = document.getElementById('addhistory');
            if (historyTable) {
                const rows = historyTable.querySelectorAll('tr');
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    if (cells.length > 0) {
                        historyRows += `
                            <tr>
                                <td style="border: 1px solid #000; padding: 8px; text-align: center;">${cells[0].innerText}</td>
                                <td style="border: 1px solid #000; padding: 8px;">${cells[1].innerText}</td>
                                <td style="border: 1px solid #000; padding: 8px;">${cells[2].innerText}</td>
                                <td style="border: 1px solid #000; padding: 8px;">${cells[3].innerText}</td>
                                <td style="border: 1px solid #000; padding: 8px;">${cells[4].innerText}</td>
                                <td style="border: 1px solid #000; padding: 8px; text-align: right;">${cells[5].innerText}</td>
                            </tr>
                        `;
                    }
                });
            }

            // Buat section kilometer untuk kendaraan pribadi dengan Digit Box Writing
            const renderDigitBoxes = (value, maxDigits = 5) => {
                // Hapus semua karakter non-digit (misal: titik ribuan)
                const cleanValue = value.toString().replace(/\D/g, '');
                const digits = cleanValue.padStart(maxDigits, '0').split('');
                return digits.map(d => `<span style="
                    display: inline-block;
                    width: 20px;
                    height: 25px;
                    border: 1px solid #000;
                    text-align: center;
                    line-height: 25px;
                    margin-right: 2px;
                    font-family: monospace;
                ">${d}</span>`).join('');
            };

            const emptyDigitBoxes = (num = 5) => {
                return Array(num).fill('').map(() => `<span style="
                    display: inline-block;
                    width: 20px;
                    height: 25px;
                    border: 1px solid #000;
                    margin-right: 2px;
                ">&nbsp;</span>`).join('');
            };

            const renderTimeBoxes = (time = '--:--') => {
                const cleanTime = time.replace(/[^0-9]/g, '').padStart(4, '0'); // Ambil hanya digit
                const digits = cleanTime.split('');
                // Format: HH:MM → kotak HH - kotak MM
                return `
                    ${digits.slice(0, 2).map(d => `
                        <span style="
                            display: inline-block;
                            width: 20px;
                            height: 25px;
                            border: 1px solid #000;
                            text-align: center;
                            line-height: 25px;
                            margin-right: 2px;
                            font-family: monospace;
                        ">${d}</span>`).join('')}
                    <span style="margin: 0 4px;">:</span>
                    ${digits.slice(2, 4).map(d => `
                        <span style="
                            display: inline-block;
                            width: 20px;
                            height: 25px;
                            border: 1px solid #000;
                            text-align: center;
                            line-height: 25px;
                            margin-right: 2px;
                            font-family: monospace;
                        ">${d}</span>`).join('')}
                `;
            };

           const kilometerSection = hasPrivateVehicle ? `
                <div style="margin-top: 5px; display: flex; justify-content: space-between;">
                    <strong>Kilometer Awal:</strong>
                    <div>${renderDigitBoxes(kilometerAwal || '0')}</div>
                </div>
                <div style="margin-top: 5px; display: flex; justify-content: space-between;">
                    <strong>Waktu Pergi:</strong>
                    <div>${renderTimeBoxes(waktuPergi || '--:--')}</div>
                </div>
                <div style="margin-top: 5px; display: flex; justify-content: space-between;">
                    <strong>Kilometer Akhir:</strong>
                    <div>${kilometerAkhir === '-' ? emptyDigitBoxes(5) : renderDigitBoxes(kilometerAkhir)}</div>
                </div>
                <div style="margin-top: 5px; display: flex; justify-content: space-between;">
                    <strong>Estimasi Waktu Kembali:</strong>
                    <div>${renderTimeBoxes(waktuPulang || '--:--')}</div>
                </div>
                <div style="margin-top: 5px; display: flex; justify-content: space-between;">
                    <strong>Waktu Kembali Aktual:</strong>
                    <div>${emptyDigitBoxes(2)}<span style="margin: 0 4px;">:</span>${emptyDigitBoxes(2)}</div>
                </div>
                <div style="margin-top: 10px; display: flex; align-items: center;">
                    <strong style="margin-right: 10px;">Alasan Tidak Sesuai Estimasi:</strong>
                    <div style="flex-grow: 1; border-bottom: 1px solid #000; height: 20px;"></div>
                </div>
            ` : '';

            // Buat window baru untuk print
            const printWindow = window.open('', '_blank', 'width=800,height=600');

            // HTML content untuk print dengan format formal
            const printContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Detail Surat Dinas - ${nomorSurat}</title>
                    <style>
                        @page {
                            margin: 20mm;
                            size: A4;
                        }
                        body {
                            font-family: 'Times New Roman', serif;
                            font-size: 12px;
                            line-height: 1.4;
                            color: #000;
                            margin: 0;
                            padding: 0;
                        }
                        .header {
                            text-align: center;
                            border-bottom: 3px solid #000;
                            padding-bottom: 15px;
                            margin-bottom: 20px;
                        }
                        .company-name {
                            font-size: 20px;
                            font-weight: bold;
                            margin-bottom: 5px;
                            text-transform: uppercase;
                        }
                        .document-title {
                            font-size: 16px;
                            font-weight: bold;
                            margin-top: 15px;
                            text-decoration: underline;
                        }
                        .document-info {
                            margin: 20px 0;
                            font-size: 13px;
                        }
                        .status-info {
                            float: right;
                            font-weight: bold;
                            margin-bottom: 10px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 15px 0;
                            font-size: 11px;
                        }
                        .section-title {
                            font-size: 14px;
                            font-weight: bold;
                            margin: 25px 0 10px 0;
                            padding: 8px;
                            background: #f0f0f0;
                            border: 1px solid #000;
                            text-align: center;
                            text-transform: uppercase;
                        }
                        th {
                            background: #f8f8f8;
                            border: 1px solid #000;
                            padding: 10px 8px;
                            text-align: center;
                            font-weight: bold;
                            font-size: 11px;
                        }
                        td {
                            border: 1px solid #000;
                            padding: 8px;
                            vertical-align: top;
                        }
                        .text-center {
                            text-align: center;
                        }
                        .signature-section {
                            margin-top: 40px;
                            display: flex;
                            justify-content: space-between;
                        }
                        .signature-box {
                            width: 200px;
                            text-align: center;
                        }
                        .signature-line {
                            border-top: 1px solid #000;
                            margin-top: 60px;
                            padding-top: 5px;
                        }
                        .print-date {
                            font-size: 10px;
                            text-align: right;
                            margin-top: 20px;
                            font-style: italic;
                        }
                        @media print {
                            body {
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                            .page-break {
                                page-break-before: always;
                            }
                            table {
                                page-break-inside: avoid;
                            }
                            tr {
                                page-break-inside: avoid;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <div class="company-name">PT. YUTAKA MANUFACTURING INDONESIA</div>
                        <div style="font-size: 12px;">MM 2100-Industrial Town Jl. Halmahera Block EE-1 Cikarang Barat, Bekasi 17520 | Telepon: +62 21 8980769 | Fax: +62 21 8980770</div>
                        <div class="document-title">SURAT DINAS</div>
                    </div>
                    <div class="document-info">
                        <div><strong>Nomor Surat:</strong> ${nomorSurat}</div>
                        ${kilometerSection}
                    </div>
                    <div class="section-title">I. INFORMASI KENDARAAN</div>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 15%;">No Kendaraan</th>
                                <th style="width: 20%;">Keterangan</th>
                                <th style="width: 15%;">Tanggal Penggunaan</th>
                                <th style="width: 15%;">Rute 1</th>
                                <th style="width: 15%;">Rute 2</th>
                                <th style="width: 15%;">Rute 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${kendaraanRows || '<tr><td colspan="7" style="text-align: center; font-style: italic;">Tidak ada data kendaraan</td></tr>'}
                        </tbody>
                    </table>
                    <div class="section-title">II. INFORMASI PESERTA</div>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 8%;">No</th>
                                <th style="width: 20%;">NRP Peserta</th>
                                <th style="width: 36%;">Nama Peserta</th>
                                <th style="width: 36%;">Departemen</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${pesertaRows || '<tr><td colspan="4" style="text-align: center; font-style: italic;">Tidak ada data peserta</td></tr>'}
                        </tbody>
                    </table>
                    <div class="section-title">III. HISTORIS PERSETUJUAN</div>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 8%;">No</th>
                                <th style="width: 20%;">Nama</th>
                                <th style="width: 12%;">Tingkatan</th>
                                <th style="width: 20%;">Departemen</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 25%;">Tanggal Persetujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${historyRows || '<tr><td colspan="5" style="text-align: center; font-style: italic;">Tidak ada data historis</td></tr>'}
                        </tbody>
                    </table>
                    <div class="signature-section">
                        <div class="signature-box">
                            <div>Dibuat Oleh:</div>
                            <div class="signature-line">
                            </div>
                        </div>
                        <div class="signature-box">
                            <div>Disetujui Oleh:</div>
                            <div class="signature-line">
                            </div>
                        </div>
                    </div>
                    <div class="print-date">
                        Dicetak pada: ${new Date().toLocaleDateString('id-ID', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}
                    </div>
                </body>
                </html>
            `;

            // Tulis content ke window baru
            printWindow.document.write(printContent);
            printWindow.document.close();

            // Tunggu sebentar untuk memastikan content dimuat, lalu print
            setTimeout(() => {
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            }, 250);
        }

        // Fungsi untuk menambahkan tombol print ke modal (opsional)
        function addPrintButtonToModal() {
            const modalFooter = document.querySelector('#suratDinasModal .modal-footer');
            if (!modalFooter) {
                // Jika tidak ada footer, buat footer baru
                const modalContent = document.querySelector('#suratDinasModal .modal-content');
                const footer = document.createElement('div');
                footer.className = 'modal-footer';
                footer.innerHTML = `
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="printSuratDinas()">
                        <i class="fas fa-print"></i> Cetak
                    </button>
                `;
                modalContent.appendChild(footer);
            } else {
                // Jika sudah ada footer, tambahkan tombol print
                const printBtn = document.createElement('button');
                printBtn.type = 'button';
                printBtn.className = 'btn btn-primary';
                printBtn.onclick = printSuratDinas;
                printBtn.innerHTML = '<i class="fas fa-print"></i> Cetak';
                modalFooter.appendChild(printBtn);
            }
        }
    </script>
</body>

</x-guest-layout>
