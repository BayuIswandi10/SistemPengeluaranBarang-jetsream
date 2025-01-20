<div class ="content-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 mt-2 text-gray-800">Form Pengeluaran Barang</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button class="btn btn-primary btn-md float-left" data-toggle="modal" data-target="#tambahDataModal">
                    <i class="fa fa-plus mr-1"></i> Tambah Data
                </button>            
            </div>
            <div class="card-body">
                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: '{{ session('success') }}',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload(); // Reload halaman untuk merefleksikan perubahan
                        });
                    </script>
                @endif

                @if (session('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: '{{ session('error') }}',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    </script>
                @endif
                <table id="dataTable" class="table table-striped table-bordered nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nomor Pengeluaran Barang</th>
                            <th>Tujuan</th>
                            <th>Jenis Kendaraan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach ($pengeluaranBarangs as $pengeluaranBarang)
                            {{-- @foreach ($pengeluaranBarang->approval as $approval) --}}
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $pengeluaranBarang->pengeluaran_barang_id }}</td>
                                    <td>{{ $pengeluaranBarang->tujuan_pengeluaran_barang }}</td>
                                    <td>{{ $pengeluaranBarang->jenis_kendaraan }}</td>
                                    <td>
                                        @if ($pengeluaranBarang->status == 'Level 4')
                                            Menunggu Persetujuan Security
                                        @elseif ($pengeluaranBarang->status == 'Level 5')
                                            Sudah Disetujui
                                        @elseif ($pengeluaranBarang->status == 'Level 1')
                                            Menunggu Persetujuan PIC/Ka.Sie
                                        @elseif ($pengeluaranBarang->status == 'Level 2')
                                            Menunggu Persetujuan Ka.Dept Ybs
                                        @elseif ($pengeluaranBarang->status == 'Level 3')
                                            Menunggu Persetujuan Ka.Dept GA
                                        @else
                                            {{ $pengeluaranBarang->status }}
                                        @endif

                                    </td>
                                    <td>
                                        <div class="button-group">
                                            @if($pengeluaranBarang->status === 'Level 0')
                                                <button 
                                                    type="button" 
                                                    class="btn btn-primary btn-sm update-status" 
                                                    data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            @endif

                                            <!-- Button detail -->
                                            <button 
                                                type="button" 
                                                class="btn btn-info btn-sm" 
                                                data-toggle="modal" 
                                                data-target="#detailModal" 
                                                data-items="{{ json_encode($pengeluaranBarang->barangKeluar) }}" 
                                                data-nomor="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa fa-list"></i>
                                            </button>
                                            <!-- Button Edit -->
                                            <button type="button" 
                                                class="btn btn-warning btn-sm" 
                                                data-toggle="modal" 
                                                data-target="#editDataModal" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}"
                                                data-jenis_kendaraan="{{ $pengeluaranBarang->jenis_kendaraan }}"
                                                data-lokasi_barang_keluar="{{ $pengeluaranBarang->lokasi_barang_keluar }}"
                                                data-tujuan_pengeluaran_barang="{{ $pengeluaranBarang->tujuan_pengeluaran_barang }}"
                                                data-barang="{{ json_encode($pengeluaranBarang->barangKeluar) }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <!-- Button Hapus -->
                                            <form action="" 
                                                method="POST" 
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    
                                                    <i class="fas fa-trash""></i>
                                                </button>
                                            </form>

                                        </div>

                                    </td>
                                </tr>
                            {{-- @endforeach --}}
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    
    {{-- Tambah Modal --}}
    <div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Pengeluaran Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('pengeluaran_barang.store') }}" enctype="multipart/form-data">
                        @csrf
    
                        <!-- Input Fields -->
                        {{-- <div class="form-group">
                            <label for="pengeluaran_barang_id">No Pengeluaran <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pengeluaran_barang_id" name="pengeluaran_barang_id" value="{{ $pengeluaranBarangId }}" placeholder="No Surat Jalan" readonly required>
                        </div>                 --}}
    
                        <div class="form-group">
                            <label for="jenis_kendaraan">Jenis Kendaraan <span class="text-danger">*</span></label>
                            <select class="form-control" id="select-tools" name="jenis_kendaraan" required>
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
                            <input type="text" class="form-control" id="lokasi_barang_keluar" name="lokasi_barang_keluar" placeholder="Masukkan lokasi barang keluar" required>
                        </div>
    
                        <div class="form-group">
                            <label for="tujuan_pengeluaran_barang">Tujuan Pengeluaran <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tujuan_pengeluaran_barang" name="tujuan_pengeluaran_barang" placeholder="Masukkan Tujuan Pengeluaran" required>
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
                                        <td><input type="text" name="barang_ids[]" class="form-control" placeholder="Nama Barang" required></td>
                                        <td><input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required></td>
                                        <td><input type="text" name="satuan[]" class="form-control" placeholder="Satuan" required></td>
                                        <td><input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan" required></td>
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
    
    {{-- Detail Modal --}}
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NO</th>
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
        </div>
    </div>
    
    
 
    {{-- Edit Modal --}}
    <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Edit Data Pengeluaran Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('pengeluaran_barang.update') }}" enctype="multipart/form-data" id="editForm">
                        @csrf
                        @method('PUT')
        
                        <input type="hidden" name="pengeluaran_barang_id" id="edit_pengeluaran_barang_id">
        
                        <div class="form-group">
                            <label for="edit_jenis_kendaraan">Jenis Kendaraan <span class="text-danger">*</span></label>
                            <select class="form-control" id="edit_jenis_kendaraan" name="jenis_kendaraan" required>
                                <option value="" disabled selected>Pilih Jenis Kendaraan</option>
                                <option value="TRUCK">TRUCK</option>
                                <option value="PICK UP">PICK UP</option>
                                <option value="SEDAN">SEDAN</option>
                                <option value="JEEP">JEEP</option>
                                <option value="SP. MOTOR">SP. MOTOR</option>
                            </select>
                        </div>
        
                        <div class="form-group">
                            <label for="edit_lokasi_barang_keluar">Lokasi Barang Keluar  <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_lokasi_barang_keluar" name="lokasi_barang_keluar" readonly>
                        </div>
        
                        <div class="form-group">
                            <label for="edit_tujuan_pengeluaran_barang">Tujuan Pengeluaran <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_tujuan_pengeluaran_barang" name="tujuan_pengeluaran_barang" required>
                        </div>
        
                        <div class="form-group">
                            <label>Detail Barang Keluar <span class="text-danger">*</span></label>
                            <table id="editBarangTable" class="table table-striped table-bordered">
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
                                    <!-- Data akan diisi melalui JavaScript -->
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success btn-sm" onclick="tambahComboBoxEdit()">
                                <i class="fas fa-plus"></i> Tambah Barang
                            </button>
                        </div>
        
                        <div class="form-group d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Ubah Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



</div>


<script>
    $('#editDataModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button yang memicu modal
        var pengeluaranBarangId = button.data('id');
        var jenisKendaraan = button.data('jenis_kendaraan');
        var lokasiBarangKeluar = button.data('lokasi_barang_keluar');
        var tujuanPengeluaranBarang = button.data('tujuan_pengeluaran_barang');
        var barangDetails = button.data('barang');

        // Set value untuk input form
        $('#edit_pengeluaran_barang_id').val(pengeluaranBarangId);
        $('#edit_jenis_kendaraan').val(jenisKendaraan);
        $('#edit_lokasi_barang_keluar').val(lokasiBarangKeluar);
        $('#edit_tujuan_pengeluaran_barang').val(tujuanPengeluaranBarang);

        // Clear the modal's barang table body
        const tableBody = $('#editBarangTable tbody');
        tableBody.empty();

        // Isi tabel barang di modal
        barangDetails.forEach((barang, index) => {
            const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td><input type="text" name="barang_ids[]" class="form-control" value="${barang.nama_barang}" required></td>
                    <td><input type="number" name="jumlah[]" class="form-control" value="${barang.jumlah_barang}" required></td>
                    <td><input type="text" name="satuan[]" class="form-control" value="${barang.satuan_barang}" required></td>
                    <td><input type="text" name="keterangan[]" class="form-control" value="${barang.keterangan_barang}" required></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBox(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
            tableBody.append(row);
        });
    });

    function tambahComboBoxEdit() {
        const tableBody = $('#editBarangTable tbody');
        const rowCount = tableBody.children().length;
        const row = `
            <tr>
                <td>${rowCount + 1}</td>
                <td><input type="text" name="barang_ids[]" class="form-control" placeholder="Nama Barang" required></td>
                <td><input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required></td>
                <td><input type="text" name="satuan[]" class="form-control" placeholder="Satuan" required></td>
                <td><input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan" required></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBox(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>`;
        tableBody.append(row);
    }
    


    document.addEventListener('DOMContentLoaded', () => {
        $('#detailModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget); // Button yang diklik
            const items = button.data('items'); // Data barang
            const nomor = button.data('nomor'); // Nomor pengeluaran barang

            // Kosongkan tabel modal
            const tbody = document.getElementById('detailBody');
            tbody.innerHTML = '';

            // Isi tabel modal dengan data
            items.forEach((item, index) => {
                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${nomor}</td>
                        <td>${item.nama_barang}</td>
                        <td>${item.jumlah_barang}</td>
                        <td>${item.satuan_barang}</td>
                        <td>${item.keterangan_barang}</td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        });
    });


    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            columnDefs: [
                {className: 'dt-body-center', targets: 0},
                {className: 'dt-head-center', targets: 0},
                {className: 'dt-body-center', targets: 5},
                {className: 'dt-head-center', targets: 5}
            ],
            scrollX: false,
            responsive: true
        });
    });

    let counter = 1;

    function tambahComboBox() {
        const container = document.getElementById('barangTable');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td class="nomor">${counter += 1}</td>
            <td><input type="text" name="barang_ids[]" class="form-control" placeholder="Nama Barang" required></td>
            <td><input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required></td>
            <td><input type="text" name="satuan[]" class="form-control" placeholder="Satuan" required></td>
            <td><input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan" required></td>
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


    document.addEventListener('DOMContentLoaded', function () {
        // Handle click event on update status button
        document.querySelectorAll('.update-status').forEach(button => {
            button.addEventListener('click', function () {
                const pengeluaranBarangId = this.getAttribute('data-id');

                // Konfirmasi menggunakan SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan melakukan submit pengeluaran barang!",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, submit!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('pengeluaran.updateStatus') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ pengeluaran_barang_id: pengeluaranBarangId })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Tampilkan notifikasi berhasil
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload(); // Reload halaman untuk merefleksikan perubahan
                                });
                            } else {
                                // Tampilkan notifikasi error
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            // Tampilkan notifikasi error jika terjadi kesalahan
                            Swal.fire({
                                title: 'Terjadi Kesalahan!',
                                text: 'Error: ' + error.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                    }
                });
            });
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