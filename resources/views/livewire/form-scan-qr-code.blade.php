
<div class="content-wrapper">
  <div class="container-fluid">
      <!-- Page Heading -->
      <h1 class="h3 mb-2 mt-2 text-gray-800">Scan barcode Pengeluaran Barang</h1>

      <div class="card shadow mb-4">
          <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Pemeriksaan Barang</h6>
          </div>
          <div class="card-body">
            <div class="container">
              <video id="preview" style="width: 100%; max-height: 250px; border-radius: 8px;"></video>
              <input type="text" style="width: 100%; max-height: 250px; border-radius: 8px;" id="scanResult" class="form-control mt-3" placeholder="Hasil scan akan muncul di sini" readonly>
            </div>
          </div>

          {{-- <div class="card-footer d-flex justify-content-center">
            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Cari</button>
          </div> --}}
      </div>
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
                    <button type="button" class="btn btn-success" id="approveButton" data-id="">Setuju</button>

                </div>
                
                <!-- Card untuk Tabel Barang Keluar -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Detail Barang Keluar</h6>
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
                        <table id="additionalInfoTable" class="table table-striped table-bordered">
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

  <audio id="beep" src="{{ asset('assets/sound/beep-sound-8333.mp3') }}" autostart="false" ></audio>
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
    });

    function fetchDetailPengeluaran(nomor) {
        document.getElementById('nomorPengeluaranCard').innerText = nomor;
        document.getElementById('approveButton').setAttribute('data-id', nomor);

        $.ajax({
            url: "/pengeluaran/detail",
            method: "POST",
            data: { pengeluaran_barang_id: nomor, "_token": "{{ csrf_token() }}" },
            success: function (data) {
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

                if (statusPengeluaran === "Level 4" && kategoriPengeluaran == 0 || (statusPengeluaran === "Level 5" && kategoriPengeluaran == 1)) {
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
                            <td>${item.jumlah_barang}</td>
                            <td>${item.satuan_barang}</td>
                            <td>${item.keterangan_barang}</td>
                        </tr>
                    `).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data barang keluar</td></tr>';
                }
                
                // Inisialisasi ulang DataTable
                $('#dataTable').DataTable({
                    responsive: true,
                    scrollX: false,
                    pageLength: 5,
                    lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                    destroy: true
                });

                // Mapping tingkatan dan status persetujuan
                const tingkatMapping = {
                    "Level 1": "Civitas",
                    "Level 2": "PIC/Ka.Sie",
                    "Level 3": "Ka.Dept.Ybs",
                    "Level 4": "Ka.Dept.GA",
                    "Level 5": "Security"
                };
                const approvMapping = {
                    "Level 1": "Mengeluarkan",
                    "Level 2": "Membawa",
                    "Level 3": "Menyetujui",
                    "Level 4": "Mengetahui",
                    "Level 5": "Memeriksa"
                };
                
                // Menambahkan data ke tabel informasi tambahan
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
              title: 'Konfirmasi',
              text: "Apakah Anda yakin ingin menyetujui pengeluaran ini?",
              icon: 'info',
              showCancelButton: true,
              reverseButtons: true,
              onfirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, setuju!',
              cancelButtonText: 'Batal'
          }).then((result) => {
              if (result.isConfirmed) {
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
  
</script>

