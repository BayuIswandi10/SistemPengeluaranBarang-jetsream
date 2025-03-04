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

    <div class="login-box">
        <div class="card card-outline card-primary login-card">
            <div class="card-body">
                <video id="preview"></video>
                <div class="input-group mt-3">
                    <input type="text" id="scanResult" class="form-control" placeholder="Scan QR atau ketik nomor pengeluaran">
                    <div class="input-group-append">
                        <button id="btnCari" class="btn btn-primary" style="background-color: #4B687E; border-radius:8px;">Cari</button>
                    </div>
                </div>
            </div>
            
            <div class="card-footer d-flex justify-content-center">
                <a href="{{ route('login') }}">
                    <x-button type="button" class="btn btn-primary mr-2" style="background-color: #4B687E; border-radius:8px;">
                        {{ __('Kembali') }}
                    </x-button>
                </a>
            </div>
        </div>
        <audio id="beep" src="{{ asset('assets/sound/beep-sound-8333.mp3') }}" autostart="false"></audio>
    </div>

    <!-- Modal untuk Menampilkan Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Barang Keluar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p><strong>Nomor Pengeluaran:</strong> <span id="nomorPengeluaranCard"></span></p>
                    </div>
                    <!-- Card untuk Tabel Barang Keluar -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Detail Barang Keluar</h6>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
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
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">Informasi Tambahan</h6>
                        </div>
                        <div class="card-body">
                            <table id="additionalInfoTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tingkatan</th>
                                        <th>Departemen</th>
                                        <th>Status</th>
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
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', () => {
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            scanner.addListener('scan', function (content) {
                document.getElementById('scanResult').value = content;
                document.getElementById('beep').play();
                fetchDetailPengeluaran(content);
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
                if (!nomor.trim()) {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Nomor pengeluaran tidak boleh kosong!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                document.getElementById('nomorPengeluaranCard').innerText = nomor;

                $.ajax({
                    url: "/pengeluaran/detailNonAuth",
                    method: "POST",
                    data: { pengeluaran_barang_id: nomor, "_token": "{{ csrf_token() }}" },
                    success: function (data) {
                        const tbody = document.getElementById('detailBody');
                        const additionalInfoBody = document.getElementById('additionalInfoBody');

                        tbody.innerHTML = '';
                        additionalInfoBody.innerHTML = '';

                        if ($.fn.DataTable.isDataTable('#dataTable')) {
                            $('#dataTable').DataTable().clear().destroy();
                        }

                        if (data.barang_keluar && data.barang_keluar.length > 0) {
                            tbody.innerHTML = data.barang_keluar.map((item, index) => `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${nomor}</td>
                                    <td>${item.nama_barang}</td>
                                    <td>${item.jumlah_barang}</td>
                                    <td>${item.satuan_barang}</td>
                                    <td>${item.keterangan_barang}</td>
                                </tr>
                            `).join('');
                        } else {
                            tbody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data barang keluar</td></tr>';
                        }

                        const tingkatMapping = {
                            "Level 1": "Civitas",
                            "Level 2": "PIC/Ka.Sie",
                            "Level 3": "Ka.Dept.Ybs",
                            "Level 4": "Ka.Dept.GA",
                            "Level 5": "Finance",
                            "Level 6": "Security"
                        };
                        const approvMapping = {
                            "Level 1": "Mengeluarkan",
                            "Level 2": "Membawa",
                            "Level 3": "Menyetujui",
                            "Level 4": "Mengetahui",
                            "Level 5": "Menerima",
                            "Level 6": "Memeriksa"
                        };

                        if (data.informasi_tambahan && data.informasi_tambahan.length > 0) {
                            additionalInfoBody.innerHTML = data.informasi_tambahan.map((info, index) => `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${info.nama}</td>
                                    <td>${tingkatMapping[info.tingkatan] || info.tingkatan}</td>
                                    <td>${info.departemen}</td>
                                    <td>${approvMapping[info.status] || info.status}</td>
                                </tr>
                            `).join('');
                        } else {
                            additionalInfoBody.innerHTML = '<tr><td colspan="5" class="text-center">Tidak ada informasi tambahan</td></tr>';
                        }

                        // Aktifkan DataTable setelah data ditambahkan
                        $('#dataTable').DataTable({
                            columnDefs: [
                                { className: 'dt-body-center', targets: 0 },
                                { className: 'dt-head-center', targets: 0 },
                                { className: 'dt-body-center', targets: 5 },
                                { className: 'dt-head-center', targets: 5 }
                            ],

                            responsive: true,
                            scrollX: false,
                            destroy: true,
                            pageLength: 5, // Menentukan jumlah default entries per page menjadi 5
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
                let nomor = document.getElementById('scanResult').value;
                fetchDetailPengeluaran(nomor);
            });

            // Biarkan pengguna menekan "Enter" untuk melakukan pencarian
            document.getElementById('scanResult').addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    let nomor = document.getElementById('scanResult').value;
                    fetchDetailPengeluaran(nomor);
                }
            });

        });
    </script>
</body>

</x-guest-layout>
