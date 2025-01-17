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
                            @foreach ($pengeluaranBarang->approval as $approval)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $pengeluaranBarang->pengeluaran_barang_id }}</td>
                                    <td>{{ $pengeluaranBarang->tujuan_pengeluaran_barang }}</td>
                                    <td>{{ $pengeluaranBarang->jenis_kendaraan }}</td>
                                    <td>{{ $approval->status_approval }}</td>
                                    <td>
                                        <div class="button-group">
                                        <!-- Button detail -->
                                        <a href="" 
                                            class="btn btn-info btn-sm">
                                            
                                            <i class="fa fa-list color-muted""></i>
                                        </a>
                                        <!-- Button Edit -->
                                        <a href="" 
                                            class="btn btn-warning btn-sm">
                                            
                                            <i class="fas fa-edit""></i>
                                        </a>
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
                            @endforeach
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
                        <div class="form-group">
                            <label for="pengeluaran_barang_id">No Pengeluaran <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pengeluaran_barang_id" name="pengeluaran_barang_id" value="{{ $pengeluaranBarangId }}" placeholder="No Surat Jalan" readonly required>
                        </div>                
    
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

    
    {{-- Edit Modal --}}    


</div>


<script>

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

    // Display validation errors in Swal
    @if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Whoops!',
        html: '<ul>' +
            @foreach ($errors->all() as $error)
                '<li>{{ $error }}</li>' +
            @endforeach
            '</ul>'
    });
    @endif

    // Display success message in Swal
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}'
        });
    @endif

    // Display error message in Swal
    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}'
        });
    @endif

    var $select = $('#select-tools').selectize({
    
    create: true
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