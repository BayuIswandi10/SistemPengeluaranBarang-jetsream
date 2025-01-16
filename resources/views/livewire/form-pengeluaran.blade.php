<div class ="content-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 mt-2 text-gray-800">Form Pengeluaran Barang</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pengeluaran Barang</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pengeluaran_barang.store') }}" enctype="multipart/form-data">
                    @csrf
    
                    <!-- Error & Success Message -->
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @elseif (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
    
                    <!-- Input Fields -->
                    <div class="form-group">
                        <label for="pengeluaran_barang_id">No Pengeluaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="pengeluaran_barang_id" name="pengeluaran_barang_id" value="{{ $pengeluaranBarangId }}" placeholder="No Surat Jalan" readonly required>
                    </div>                
                    
                    {{-- <div class="form-group">
                        <label for="created_by">NRP Karyawan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="created_by" name="created_by" value="{{ old('created_by') }}" placeholder="Masukkan NRP Karyawan" required>
                    </div> --}}
    
                    <div class="form-group">
                        <label for="jenis_kendaraan">Jenis Kendaraan <span class="text-danger">*</span></label>
                        
                        <select class="form-control" id="select-tools" name="jenis_kendaraan" required>
                            <option value="" disabled selected>Pilih Jenis Kendaraan</option>
                            <option value="TRUCK" {{ old('jenis_kendaraan') == 'TRUCK' ? 'selected' : '' }}>TRUCK</option>
                            <option value="PICK UP" {{ old('jenis_kendaraan') == 'PICK UP' ? 'selected' : '' }}>PICK UP</option>
                            <option value="SEDAN" {{ old('jenis_kendaraan') == 'SEDAN' ? 'selected' : '' }}>SEDAN</option>
                            <option value="JEEP" {{ old('jenis_kendaraan') == 'JEEP' ? 'selected' : '' }}>JEEP</option>
                            <option value="SP. MOTOR" {{ old('jenis_kendaraan') == 'SP. MOTOR' ? 'selected' : '' }}>SP. MOTOR</option>
                        </select>
                    </div>
                    
    
                    <div class="form-group">
                        <label for="tujuan_pengeluaran_barang">Tujuan Pengeluaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tujuan_pengeluaran_barang" name="tujuan_pengeluaran_barang" value="{{ old('tujuan_pengeluaran_barang') }}" placeholder="Masukkan Tujuan Pengeluaran" required>
                    </div>
    
                    <!-- Barang Keluar Table -->
                    <div class="form-group">
                        <label>Detail Barang Keluar <span class="text-danger">*</span></label>
                        <table id="dataTable" class="display nowrap table-striped table" style="width:100%">
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
                            <tbody id="barangTable">
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
                            <i class="fas fa-plus mr-2"></i>Tambah Barang
                        </button>                
                    </div>
    
                    <!-- Submit Button -->
                    <div class="form-group d-flex justify-content-end mt-3">
                        <a href="" class="btn btn-secondary  mr-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
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