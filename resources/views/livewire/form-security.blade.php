<div class="content-wrapper">
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
    <div class="container-fluid">
  
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center" style="border-top: 5px solid #5A6ACF;">
                <h6 class="m-0 font-weight-bold text-primary">Pemeriksaan</h6>
            </div>
            <div class="card-body">
              <div class="container">
                <video id="preview" style="width: 100%; max-height: 250px; border-radius: 8px;"></video>
                <input type="text" id="scanResult" class="form-control mt-3" placeholder="Masukkan atau scan barcode" autofocus autocomplete="off">
                <button type="button" class="btn btn-success mt-2" id="searchButton">Cari</button>
              </div>
            </div>
        </div>
    </div>
  
    <!-- Modal untuk Menampilkan Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h5 class="modal-title" id="detailModalLabel">Detail Barang Keluar</h5>
                        <!-- Badge Status di Header -->
                        <div id="approvalStatusBadge"></div>
                    </div>
                    <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Info Nomor Pengeluaran dan Kategori -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <p><strong>Nomor Pengeluaran:</strong> <span id="nomorPengeluaranCard"></span></p>
                        <div id="kategoriBarangCard"></div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p><strong>Nomor Polisi:</strong> <span id="nomorPolisiCard"></span></p>
                    </div>
                    
                    <!-- Card untuk Tabel Barang Keluar -->
                    <div class="card">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Informasi Barang Keluar</h6>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="table table-bordered">
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
                            <div class="table-responsive">
                            <table id="additionalInfoTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tingkatan</th>
                                        <th>Departemen</th>
                                        <th>Status</th>
                                        <th>Alasan Penolakan</th>
                                    </tr>
                                </thead>
                                <tbody id="additionalInfoBody">
                                    <!-- Data akan diisi secara dinamis -->
                                </tbody>
                            </table>
                        </div>   
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-success" id="approveButton" data-id="">Setujui</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Dinas --}}
    <div class="modal fade" id="suratDinasModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h5 class="modal-title" id="detailModalLabel">Detail Surat Dinas</h5>
                        <!-- Badge Status di Header -->
                        <div id="approvalStatusBadgeDinas"></div>
                    </div>
                    <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p><strong>Nomor Surat:</strong> <span id="nomorSuratCard"></span></p>
                        <button type="button" class="btn btn-success" id="approveButtonDinas" data-id="">Setuju</button>

                    </div>

                    <!-- Card untuk Tabel Informasi Kendaraan -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">Informasi Kendaraan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="kendaraanInfoTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Kendaraan</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Penggunaan</th>
                                        <th>Tujuan 1</th>
                                        <th>Tujuan 2</th>
                                        <th>Tujuan 3</th>
                                    </tr>
                                </thead>
                                <tbody id="kendaraanInfoBody">
                                    <!-- Data akan diisi secara dinamis -->
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>

                    <!-- Card untuk Tabel Barang Keluar -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Informasi Peserta</h6>
                        </div>
                        <div class="card-body">
                            <table id="detaildataTableModal" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
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
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">Informasi Historis Persetujuan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="additionalInfoTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tingkatan</th>
                                        <th>Departemen</th>
                                        <th>Status</th>
                                        <th>Alasan Penolakan</th>
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
            </div>
        </div>
    </div>

  <audio id="beep" src="{{ asset('assets/sound/beep-sound-8333.mp3') }}" autostart="false" ></audio>
</div>


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    //   scanner.addListener('scan', function (content) {
    //       document.getElementById('scanResult').value = content;
    //       document.getElementById('beep').play();
    //       fetchDetailPengeluaran(content);
    //   });

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
    });

    function fetchDetailPengeluaran(nomor) {
        document.getElementById('nomorPengeluaranCard').innerText = nomor;
        document.getElementById('approveButton').setAttribute('data-id', nomor);

        $.ajax({
            url: "/pengeluaran/detail",
            method: "POST",
            data: { pengeluaran_barang_id: nomor, "_token": "{{ csrf_token() }}" },
            success: function (data) {
                 // Tampilkan badge kategori
                document.getElementById('kategoriBarangCard').innerHTML = 
                    data.kategori_pengeluaran === 1 
                    ? '<span class="badge badge-danger px-2 py-3">Scrap</span>' 
                    : '<span class="badge badge-info px-2 py-3">Non Scrap</span>';

                // Badge besar status persetujuan
                const maxLevel = Math.max(...(data.informasi_tambahan ?? []).map(x => parseInt(x.status?.replace('Level ', '')) || 0));
                const adaYangMenolak = (data.informasi_tambahan ?? []).some(x => x.status === 'Level 0');

                let statusBadgeHTML = '';

                if (adaYangMenolak) {
                    // Status DITOLAK
                    statusBadgeHTML = `
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 130px; height: 40px; font-size: 0.85rem; padding: 0.25rem; border-radius: 0.5rem; background-color: #dc3545; color: white;">
                            <i class="fas fa-times-circle" style="font-size: 1rem; margin-right: 6px;"></i> Ditolak
                        </span>
                    `;
                } else if (
                    (data.kategori_pengeluaran === 1 && maxLevel >= 5) || 
                    (data.kategori_pengeluaran === 0 && maxLevel >= 4)
                ) {
                    // Status LENGKAP
                    statusBadgeHTML = `
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 130px; height: 40px; font-size: 0.85rem; padding: 0.25rem; border-radius: 0.5rem; background-color: #28a745; color: white;">
                            <i class="fas fa-check-circle" style="font-size: 1rem; margin-right: 6px;"></i> Lengkap
                        </span>
                    `;
                } else {
                    // Status BELUM LENGKAP
                    statusBadgeHTML = `
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 150px; height: 40px; font-size: 0.85rem; padding: 0.25rem; border-radius: 0.5rem; background-color: #ffc107; color: black;">
                            <i class="fas fa-exclamation-circle" style="font-size: 1rem; margin-right: 6px;"></i> Belum Lengkap
                        </span>
                    `;
                }

                document.getElementById('approvalStatusBadge').innerHTML = statusBadgeHTML;
        
                document.getElementById('nomorPolisiCard').innerText = data.no_polisi || '-';
                const tbody = document.getElementById('detailBody');
                const additionalInfoBody = document.getElementById('additionalInfoBody');
                
                tbody.innerHTML = '';
                additionalInfoBody.innerHTML = '';

                // Hapus DataTable sebelum menambahkan data baru
                if ($.fn.DataTable.isDataTable('#dataTable')) {
                    $('#dataTable').DataTable().clear().destroy();
                }

                let statusPengeluaran = data.status; // Pastikan API mengembalikan status
                let kategoriPengeluaran = data.kategori_pengeluaran;

                let nomorPolisi = data.no_polisi;

                if (
                    ((statusPengeluaran === "Level 4" && kategoriPengeluaran == 0) ||
                    (statusPengeluaran === "Level 5" && kategoriPengeluaran == 1)) &&
                    nomorPolisi && nomorPolisi.trim() !== "Tidak Ada"
                ) {
                    document.getElementById('approveButton').style.display = "inline-block"; // Tampilkan tombol
                } else {
                    document.getElementById('approveButton').style.display = "none"; // Sembunyikan tombol
                }
                
                // Menambahkan data ke tabel barang keluar
                if (data.barang_keluar && data.barang_keluar.length > 0) {
                    tbody.innerHTML = data.barang_keluar.map((item, index) => `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${nomor}</td>
                            <td>${item.nama_barang}</td>
                            <td>${Number(item.jumlah_barang).toLocaleString('id-ID')}</td>
                            <td>${item.satuan_barang}</td>
                            <td>${item.keterangan_barang ?? ''}</td>
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
                    "Level 1": "Mengeluarkan",
                    "Level 2": "Membawa",
                    "Level 3": "Menyetujui",
                    "Level 4": "Mengetahui",
                    "Level 5": "Menerima",
                    "Level 6": "Memeriksa"
                };
                
                // Menambahkan data ke tabel informasi tambahan
                if (data.informasi_tambahan && data.informasi_tambahan.length > 0) {
                    data.informasi_tambahan.forEach((info, index) => {
                        let alasanPenolakan = (index === data.informasi_tambahan.length - 1) 
                            ? info.alasan_penolakan 
                            : '-'; // hanya isi di baris terakhir

                        let row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${info.nama}</td>
                                <td>${tingkatMapping[info.tingkatan] || info.tingkatan}</td>
                                <td>${info.departemen}</td>
                                <td>${approvMapping[info.status] || info.status}</td>
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

    document.getElementById('searchButton').addEventListener('click', function () {
        let barcodeValue = document.getElementById('scanResult').value.trim();
        
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


    document.getElementById('scanResult').addEventListener('keydown', function (event) {
        if (event.key === "Enter") {
            let barcodeValue = this.value.trim();
            
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

        

    document.getElementById('approveButton').addEventListener('click', function () {
          let pengeluaranBarangId = this.getAttribute('data-id');

          if (!pengeluaranBarangId) {
              Swal.fire({
                  title: 'Error!',
                  text: 'Nomor pengeluaran tidak ditemukan.',
                  icon: 'error',
                  confirmButtonText: 'OK'
              });
              return;
          }

          Swal.fire({
              title: 'Konfirmasi Persetujuan',
              text: 'Apakah Anda menyetujui penngeluaran barang dengan nomor ' + pengeluaranBarangId + '?',
              icon: 'info',
              showCancelButton: true,
              reverseButtons: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, setuju!',
              cancelButtonText: 'Batal'
          }).then((result) => {
              if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        html: 'sedang menyimpan persetujuan anda.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                  $.ajax({
                      url: "/approval/update-status-security",
                      method: "POST",
                      data: {
                          pengeluaran_barang_id: pengeluaranBarangId,
                          "_token": "{{ csrf_token() }}"
                      },
                      success: function (response) {
                          Swal.fire({
                              title: 'Berhasil!',
                              text: response.message,
                              icon: 'success',
                              confirmButtonText: 'OK'
                          }).then(() => {
                              $('#detailModal').modal('hide');
                              location.reload();
                          });
                      },
                      error: function (xhr, status, error) {
                          Swal.fire({
                              title: 'Gagal!',
                              text: xhr.responseJSON?.message || 'Terjadi kesalahan.',
                              icon: 'error',
                              confirmButtonText: 'OK'
                          });
                      }
                  });
              }
          });
    });

    document.getElementById('approveButtonDinas').addEventListener('click', function () {
          let suratDinasId = this.getAttribute('data-id');

          if (!suratDinasId) {
              Swal.fire({
                  title: 'Error!',
                  text: 'Nomor pengeluaran tidak ditemukan.',
                  icon: 'error',
                  confirmButtonText: 'OK'
              });
              return;
          }

          Swal.fire({
              title: 'Konfirmasi Persetujuan',
              text: 'Apakah Anda menyetujui penggunaan kendaraan dinas dengan nomor ' + suratDinasId + '?',
              icon: 'info',
              showCancelButton: true,
              reverseButtons: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, setuju!',
              cancelButtonText: 'Batal'
          }).then((result) => {
              if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        html: 'sedang menyimpan persetujuan anda.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                  $.ajax({
                      url: "/approval-dinas/update-status-security",
                      method: "POST",
                      data: {
                        surat_kendaraan_dinas_id: suratDinasId,
                          "_token": "{{ csrf_token() }}"
                      },
                      success: function (response) {
                          Swal.fire({
                              title: 'Berhasil!',
                              text: response.message,
                              icon: 'success',
                              confirmButtonText: 'OK'
                          }).then(() => {
                              $('#suratDinasModal').modal('hide');
                              location.reload();
                          });
                      },
                      error: function (xhr, status, error) {
                          Swal.fire({
                              title: 'Gagal!',
                              text: xhr.responseJSON?.message || 'Terjadi kesalahan.',
                              icon: 'error',
                              confirmButtonText: 'OK'
                          });
                      }
                  });
              }
          });
    });

    function fetchDetailKendaraan(nomor) {
        document.getElementById('nomorSuratCard').innerText = nomor;
        document.getElementById('approveButtonDinas').setAttribute('data-id', nomor);
        $.ajax({
                url: "/pengajuan/detailSurat",
                method: "POST",
                data: { surat_kendaraan_dinas_id: nomor, "_token": "{{ csrf_token() }}" },
                success: function (data) {
                    const detailTable = $('#detaildataTableModal').DataTable();

                    const jenisKendraan = {
                        1 : "Mengeluarkan"
                    };

                    let statusBadgeHTML = '';
                    const informasiTambahan = data.informasi_tambahan ?? [];

                    // Cek apakah ada yang menolak
                    const adaYangMenolak = informasiTambahan.some(x => x.status === 'Level 0');

                    // Cek level tertinggi yang menyetujui
                    const maxLevel = Math.max(...informasiTambahan.map(x => parseInt(x.status?.replace('Level ', '')) || 0));

                    if (adaYangMenolak) {
                        statusBadgeHTML = `
                            <span style="display: inline-flex; align-items: center; justify-content: center; width: 110px; height: 40px; font-size: 0.85rem; padding: 0.25rem; border-radius: 0.5rem; background-color: #dc3545; color: white;">
                                <i class="fas fa-times-circle" style="font-size: 1rem; margin-right: 4px;"></i> Ditolak
                            </span>
                        `;
                    } else if (maxLevel >= 3) {
                        statusBadgeHTML = `
                            <span style="display: inline-flex; align-items: center; justify-content: center; width: 110px; height: 40px; font-size: 0.85rem; padding: 0.25rem; border-radius: 0.5rem; background-color: #28a745; color: white;">
                                <i class="fas fa-check-circle" style="font-size: 1rem; margin-right: 4px;"></i> Lengkap
                            </span>
                        `;
                    } else {
                        statusBadgeHTML = `
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 150px; height: 40px; font-size: 0.85rem; padding: 0.25rem; border-radius: 0.5rem; background-color: #ffc107; color: black;">
                                <i class="fas fa-exclamation-circle" style="font-size: 1rem; margin-right: 6px;"></i> Belum Lengkap
                            </span>
                        `;
                    }

                    document.getElementById('approvalStatusBadgeDinas').innerHTML = statusBadgeHTML;

                    // Kosongkan data lama kendaraan
                    document.getElementById('kendaraanInfoBody').innerHTML = "";

                    if ($.fn.DataTable.isDataTable('#detaildataTableModal')) {
                            $('#detaildataTableModal').DataTable().clear().destroy();
                    }

                    // Ambil status terakhir (item terakhir dalam array informasi_tambahan)
                    const statusTerakhir = informasiTambahan.length > 0
                        ? informasiTambahan[informasiTambahan.length - 1].status
                        : null;

                    // Cek tombol hanya muncul kalau level terakhir tepat "Level 3"
                    if (statusTerakhir === "Level 3" && !adaYangMenolak) {
                        document.getElementById('approveButtonDinas').style.display = "inline-block";
                    } else {
                        document.getElementById('approveButtonDinas').style.display = "none";
                    }

                    // Validasi dan tampilkan data kendaraan
                    if (data.data_kendaraan && data.data_kendaraan.length > 0) {
                        data.data_kendaraan.forEach((item, index) => {
                            let row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.nomor_kendaraan}</td>
                                    <td>${item.keterangan}</td>
                                    <td>${item.tanggal_penggunaan || '-'}</td>
                                    <td>${item.tujuan_penggunaan_1 || '-'}</td>
                                    <td>${item.tujuan_penggunaan_2 || '-'}</td>
                                    <td>${item.tujuan_penggunaan_3 || '-'}</td>
                                </tr>
                            `;
                            document.getElementById('kendaraanInfoBody').innerHTML += row;
                        });
                    } else {
                        document.getElementById('kendaraanInfoBody').innerHTML = `
                            <tr><td colspan="4" class="text-center">Tidak ada data kendaraan</td></tr>
                        `;
                    }

                    // Kosongkan data lama
                    detailTable.clear();
                    document.getElementById('addhistory').innerHTML = ""; // Kosongkan tabel Informasi Tambahan

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
                        detailTable.rows.add([["", "", "Tidak ada data user", "", "", ""]]).draw();
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
                        "Level 3": "Mengetahui",
                        "Level 4": "Memeriksa"
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
                                        <td>${index + 1}</td>
                                        <td>${info.nama}</td>
                                        <td>${tingkatMapping[info.tingkatan] || info.tingkatan}</td>
                                        <td>${info.departemen}</td>
                                        <td>${approvMapping[info.status] || info.status}</td>
                                        <td>${alasanPenolakan}</td>
                                    </tr>
                                `;
                                additionalInfoBody.innerHTML += row;
                            });
                        } else {
                        additionalInfoBody.innerHTML = `
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada informasi tambahan</td>
                            </tr>
                        `;
                    }

                    // Aktifkan DataTable setelah data ditambahkan
                    $('#detaildataTableModal').DataTable({
                        columnDefs: [
                            { className: 'dt-body-center', targets: 0 },
                            { className: 'dt-head-center', targets: 0 },
                            { className: 'dt-body-center', targets: 3 },
                            { className: 'dt-head-center', targets: 3 }
                        ],

                        responsive: true,
                        scrollX: false,
                        destroy: true,
                        pageLength: 5, // Menentukan jumlah default entries per page menjadi 5
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


  
</script>

