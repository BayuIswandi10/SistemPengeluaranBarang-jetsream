

<x-guest-layout>
    <body  style="background-image: url('{{ asset('assets/img/PT YMI Plant 2.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; overflow: hidden;">
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
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif


        <div class="nav-static-top d-flex justify-content-between align-items-center p-3 bg-light">
            <div class="float-left">
                <a href="#">
                    <img class="mt-3 ml-4" src="{{ asset('assets/img/Logo YMI-DLT.png') }}" style="height:40px;">
                </a>
            </div>

            <ul class="nav">
                <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#tambahDataModal">Pengajuan Pengeluaran Barang</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Pengajuan Kendaraan Dinas</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href={{ route('login') }}>Masuk</a>
                    </div>
                </li>
            </ul>
            

            {{-- Tambah Modal --}}
            <div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Pengeluaran Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                    <select class="form-control select-tools" id="lokasi_barang_keluar" name="lokasi_barang_keluar" required autocomplete="off">
                                        <option value="" disabled selected>Pilih Lokasi Barang Keluar</option>
                                        <option value="P1">P1</option>
                                        <option value="P2">P2</option>
                                    </select>
                                </div>

                                <div class="form-group mt-3" id="custom-location-group-destination">
                                    <label for="tujuan_pengeluaran_barang">Tujuan Pengeluaran <span class="text-danger">*</span></label>
                                    {{-- <input type="text" class="form-control" id="tujuan_pengeluaran_barang" name="tujuan_pengeluaran_barang" placeholder="Masukkan Tujuan Pengeluaran" required autocomplete="off"> --}}
                                    <select class="form-control select-tools" id="tujuan_pengeluaran_barang" name="tujuan_pengeluaran_barang" required autocomplete="off">
                                        <option value="" disabled selected>Pilih Lokasi Barang Keluar</option>
                                        <option value="P1">P1</option>
                                        <option value="P2">P2</option>
                                    </select>
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
    </body>
    <script>


        let counter = 1;

        function tambahComboBox() {
            const container = document.getElementById('barangTable');
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



