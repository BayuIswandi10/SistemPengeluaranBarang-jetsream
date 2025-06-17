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
                <h5 class="m-0 font-weight-bold text-primary">Pemeriksaan</h5>
            </div>
            <div class="card-body">
              <div class="container">
                <video id="preview" style="width: 100%; max-height: 250px; border-radius: 8px;"></video>
                <div class="d-flex mt-3 gap-2">
                    <input type="text" id="scanResult" class="form-control me-2" placeholder="Scan QR-Code atau Ketik No Surat" autofocus autocomplete="off">
                    <button type="button" class="btn btn-primary" id="searchButton">Cari</button>
                </div>
              </div>
            </div>
        </div>
    </div>
  
   <!-- Modal untuk Menampilkan Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" id="modalHeader" style="position: relative;">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h5 class="modal-title" id="detailModalLabel">Detail Barang Keluar</h5>
                    </div>
                    <div style="position: absolute; right: 50px; top: 50%; transform: translateY(-50%); display: flex; align-items: center; gap: 10px;">
                        <i id="categoryIcon" style="font-size: 1.8rem; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;"></i>
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
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Informasi Barang Keluar</h6>
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
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Informasi Tambahan</h6>
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
                                            <th>Alasan Penolakan</th>
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
                    <button type="button" class="btn btn-success" id="approveButton" data-id="">
                        <i class="fa-solid fa-check-circle ml-2"></i>
                        Setujui
                    </button>
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
                        <h5 class="modal-title" >Detail Surat Kendaraan Dinas</h5>
                    </div>
                    <div style="position: absolute; right: 50px; top: 50%; transform: translateY(-50%); display: flex; align-items: center; gap: 10px;">
                        <i id="statusIconKendaraan" style="font-size: 1.8rem; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;"></i>
                    </div>
                    <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

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
                                        <th>Keberangkatan</th>
                                        <th>Estimasi Kepulangan</th>
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

                    <!-- Card untuk Tabel Barang Keluar -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Informasi Peserta</h6>
                        </div>
                        <div class="card-body">
                            <table id="detaildataTableModal" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Surat Kendaraan Dinas</th>
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
                            {{-- Tabel Baru Jika Surat Persetujuan Ganda --}}
                            <div id="approvalContainer"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" id="approveButtonDinas" data-id="">
                        <i class="fa-solid fa-check-circle ml-2"></i>
                        Setujui
                    </button>
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
        document.getElementById('approveButton').setAttribute('data-id', nomor);

        $.ajax({
            url: "/pengeluaran/detail",
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
                    modalHeader.style.backgroundColor = '#ffc107';
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

                if (
                    ((statusPengeluaran === "Level 4" && kategoriPengeluaran == 0) ||
                    (statusPengeluaran === "Level 5" && kategoriPengeluaran == 1)) &&
                    nomorPolisi && nomorPolisi.trim() !== "Tidak Ada"
                ) {
                    document.getElementById('approveButton').style.display = "inline-block";
                } else {
                    document.getElementById('approveButton').style.display = "none";
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
                                <td>${index + 1}</td>
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
              confirmButtonColor: '#28a745',
              cancelButtonColor: '#6c757d',
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
        let suratListJson = this.getAttribute('data-surat-list');

        if (!suratListJson) {
            Swal.fire({
                title: 'Error!',
                text: 'Tidak ada surat yang dapat disetujui.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        let suratList = [];
        try {
            suratList = JSON.parse(suratListJson);
        } catch (e) {
            Swal.fire({
                title: 'Error!',
                text: 'Format data surat tidak valid.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (suratList.length === 0) {
            Swal.fire({
                title: 'Error!',
                text: 'Tidak ada surat yang dapat disetujui.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Tampilkan daftar surat yang akan di-approve
        const suratListText = suratList.length === 1 
            ? `surat nomor ${suratList[0]}`
            : `${suratList.length} surat berikut:\n${suratList.map((s, i) => `${i+1}. ${s}`).join('\n')}`;

        Swal.fire({
            title: 'Konfirmasi Persetujuan',
            html: `Apakah Anda menyetujui penggunaan kendaraan dinas untuk ${suratListText}?`,
            icon: 'info',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, setuju!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Sedang menyimpan persetujuan anda.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // KIRIM SEMUA NOMOR SURAT UNTUK DI-APPROVE
                $.ajax({
                    url: "/approval-dinas/update-status-security",
                    method: "POST",
                    data: {
                        surat_kendaraan_dinas_ids: suratList,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
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
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    }
                });
            }
        });
    });

    function fetchDetailKendaraan(nomor) {
        // Mulai AJAX request ke endpoint untuk mengambil detail surat
        $.ajax({
            url: "/pengajuan/scanSecuritySuratDinas",
            method: "POST",
            data: {
                surat_kendaraan_dinas_id: nomor,
                "_token": "{{ csrf_token() }}"
            },
            success: function (data) {
                const detailTable = $('#detaildataTableModal').DataTable();
                const statusIcon = document.getElementById('statusIconKendaraan');
                const modalHeader = document.getElementById('modalHeaderKendaraan');

                // Karena ada banyak peserta, cari peserta yang no_surat-nya sesuai nomor
                const peserta = data.peserta.find(p => p.no_surat === nomor);

                // Ambil informasi tambahan dari peserta tersebut
                const informasiTambahan = peserta?.informasi_tambahan ?? [];

                // Cek apakah ada yang menolak (status "Level 0")
                const adaYangMenolak = informasiTambahan.some(info => info.status === 'Level 0');

                // Cari level approval tertinggi (Level 1, 2, 3, dst)
                const maxLevel = informasiTambahan.reduce((max, info) => {
                    let level = 0;
                    if (info.status && info.status.startsWith('Level ')) {
                        level = parseInt(info.status.replace('Level ', '')) || 0;
                    }
                    return level > max ? level : max;
                }, 0);

                // Buat tampilan badge status approval
                let statusBadgeHTML = '';
                if (adaYangMenolak) {
                    // Status DITOLAK
                    modalHeader.style.backgroundColor = '#dc3545';
                    modalHeader.style.color = 'white';
                    statusIcon.className = 'fas fa-times-circle';
                    statusIcon.style.color = 'white';
                    statusIcon.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
                } else if (maxLevel >= 3){
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

                // Kosongkan dulu tabel kendaraan (tbody dengan id kendaraanInfoBody)
                document.getElementById('kendaraanInfoBody').innerHTML = "";

                // Jika DataTable peserta sudah ada, reset dulu agar tidak duplicate
                if ($.fn.DataTable.isDataTable('#detaildataTableModal')) {
                    $('#detaildataTableModal').DataTable().clear().destroy();
                }

                // KUMPULKAN SEMUA NOMOR SURAT YANG BISA DI-APPROVE
                const approveableSuratNumbers = [];
                
                data.peserta.forEach(pesertaItem => {
                    const informasiTambahanItem = pesertaItem.informasi_tambahan || [];
                    const adaYangMenolakItem = informasiTambahanItem.some(info => info.status === 'Level 0');
                    const statusTerakhirItem = informasiTambahanItem.length > 0
                        ? informasiTambahanItem[informasiTambahanItem.length - 1].status
                        : null;
                        
                    // Jika status terakhir Level 3 dan tidak ada penolakan, masukkan ke list
                    if (statusTerakhirItem === "Level 3" && !adaYangMenolakItem) {
                        approveableSuratNumbers.push(pesertaItem.no_surat);
                    }
                });

                // Tampilkan tombol approve jika ada surat yang bisa di-approve
                const approveButton = document.getElementById('approveButtonDinas');
                if (approveableSuratNumbers.length > 0) {
                    approveButton.style.display = "inline-block";
                    // SIMPAN SEMUA NOMOR SURAT YANG BISA DI-APPROVE
                    approveButton.setAttribute('data-surat-list', JSON.stringify(approveableSuratNumbers));
                    
                    // Update text button untuk menunjukkan jumlah surat
                    if (approveableSuratNumbers.length === 1) {
                        approveButton.innerHTML = '<i class="fa-solid fa-check-circle mr-1"></i>Setujui';
                    } else {
                        approveButton.innerHTML = `<i class="fa-solid fa-check-circle mr-1"></i>Setujui ${approveableSuratNumbers.length} Surat`;
                    }
                } else {
                    approveButton.style.display = "none";
                    approveButton.removeAttribute('data-surat-list');
                }

                // Tampilkan data kendaraan pada tabel
                if (data.data_kendaraan && data.data_kendaraan.length > 0) {
                    data.data_kendaraan.forEach((item, index) => {
                        let row = `
                            <tr>
                                <td style="text-align: center;">${index + 1}</td>
                                <td>${item.nomor_kendaraan}</td>
                                <td>${item.keterangan}</td>
                                <td>${item.waktu_pergi || '-'}</td>
                                <td>${item.estimasi_waktu_kembali || '-'}</td>
                                <td style="text-align: right;">${item.tanggal_penggunaan || '-'}</td>
                                <td>${item.tujuan_penggunaan_1 || '-'}</td>
                                <td>${item.tujuan_penggunaan_2 || '-'}</td>
                                <td>${item.tujuan_penggunaan_3 || '-'}</td>
                                <td>${item.alasan_penggunaan || '-'}</td>
                            </tr>`;
                        document.getElementById('kendaraanInfoBody').innerHTML += row;
                    });
                } else {
                    document.getElementById('kendaraanInfoBody').innerHTML = `
                        <tr><td colspan="7" style="text-align:center;">Tidak ada data kendaraan</td></tr>`;
                }

                // Kosongkan tabel peserta dulu
                detailTable.clear();

                if (data.peserta && data.peserta.length > 0) {
                    const pesertaData = data.peserta.map((p, i) => [
                        i + 1,           // No urut
                        p.no_surat,      // Nomor Surat Kendaraan Dinas dari peserta
                        p.nrp_karyawan,  // NRP Peserta
                        p.name,          // Nama Peserta
                        p.departemen     // Departemen
                    ]);
                    detailTable.clear();
                    detailTable.rows.add(pesertaData).draw();
                } else {
                    detailTable.clear();
                    detailTable.rows.add([["", "", "", "Tidak ada data peserta", ""]]).draw();
                }

                // Mapping untuk tampilan tingkat dan status approval agar user friendly
                const tingkatMapping = {
                    "Ka.Sie": "PIC/Ka.Sie",
                    "Ka.Dept": "Ka.Dept.Ybs",
                    "GA": "Ka.Dept.GA",
                    "Finance": "Finance",
                    "Security": "Security"
                };

                const approvMapping = {
                    "Level 0": "Menolak",
                    "Level 1": "Mengajukan",
                    "Level 2": "Menyetujui",
                    "Level 3": "Menyetujui",
                    "Level 4": "Menyetujui"
                };

                const pesertaList = data.peserta;
                const container = document.getElementById("approvalContainer"); 

                // Bersihkan container lebih dulu
                container.innerHTML = "";

                // Loop setiap peserta
                pesertaList.forEach(peserta => {
                    const informasiTambahan = peserta.informasi_tambahan;

                    // Buat heading dan table baru
                    let tableHTML = `
                        <div style="margin-bottom: 30px;">
                            <h5>No Surat: ${peserta.no_surat}</h5>
                            <table border="1" style="width:100%; border-collapse: collapse;"  class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tingkatan</th>
                                        <th>Departemen</th>
                                        <th>Status Persetujuan</th>
                                        <th>Tanggal Persetujuan</th>
                                        <th>Alasan Penolakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                    if (informasiTambahan && informasiTambahan.length > 0) {
                        informasiTambahan.forEach((info, index) => {
                            const alasanPenolakan = (index === informasiTambahan.length - 1) ? info.alasan_penolakan || "-" : "-";

                            tableHTML += `
                                <tr>
                                    <td style="text-align:center;">${index + 1}</td>
                                    <td>${info.nama}</td>
                                    <td>${tingkatMapping[info.tingkatan] || info.tingkatan}</td>
                                    <td>${info.departemen}</td>
                                    <td>${approvMapping[info.status] || info.status}</td>
                                    <td style="text-align:right;">${info.created_date}</td>
                                    <td>${alasanPenolakan}</td>
                                </tr>
                            `;
                        });
                    } else {
                        tableHTML += `
                            <tr>
                                <td colspan="7" style="text-align:center;">Tidak ada informasi tambahan</td>
                            </tr>
                        `;
                    }

                    tableHTML += `
                                </tbody>
                            </table>
                        </div>
                    `;

                    container.innerHTML += tableHTML;
                });

                // Inisialisasi ulang DataTable
                $('#detaildataTableModal').DataTable({
                    columnDefs: [
                        { className: 'dt-head-center', targets: [0] },
                        { className: 'dt-body-center', targets: [0] },
                        { className: 'dt-body-left', targets: [1, 2, 3, 4] }
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

                // Tampilkan modal popup dengan id suratDinasModal
                $('#suratDinasModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error("Gagal mengambil data:", error);
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

