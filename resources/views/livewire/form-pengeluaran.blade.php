<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Form Pengeluaran Barang</h1>
    <p class="mb-4">Gunakan form ini untuk mencatat pengeluaran barang dengan detail yang lengkap.</p>

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
                    <select class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" required>
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
                    <label>Detail Barang Keluar <span class="text-danger">*</span>
                        <button type="button" class="btn btn-primary btn-sm" onclick="tambahComboBox()">Tambah Barang</button>
                    </label>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="barangTable">
                            <tr>
                                <td><input type="text" name="barang_ids[]" class="form-control" placeholder="Nama Barang" required></td>
                                <td><input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required></td>
                                <td><input type="text" name="satuan[]" class="form-control" placeholder="Satuan" required></td>
                                <td><input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan" required></td>
                                <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBox(this)">Hapus</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>


<script>
    let counter = 1;

    function tambahComboBox() {
        const container = document.getElementById('barangTable');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td><input type="text" name="barang_ids[]" class="form-control" placeholder="Nama Barang" required></td>
            <td><input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required></td>
            <td><input type="text" name="satuan[]" class="form-control" placeholder="Satuan" required></td>
            <td><input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan" required></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBox(this)">Hapus</button></td>
        `;

        container.appendChild(newRow);
    }

    function hapusComboBox(button) {
        const container = document.getElementById('barangTable');
        const rows = container.getElementsByTagName('tr');
        if (rows.length > 1) {
            const row = button.closest('tr');
            row.remove();
        } else {
            alert('Tidak bisa menghapus baris terakhir.');
        }
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
</script>