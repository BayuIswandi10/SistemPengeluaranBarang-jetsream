<div class ="content-wrapper">
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
        <div class="card-header" style="border-top: 5px solid #5A6ACF; display: flex; align-items: center; padding: 0.75rem 1.25rem;">
            <h6 class="m-0 font-weight-bold text-primary" style="flex-grow: 1;">Data Persetujuan</h6>

            @if(Auth::check() && Auth::user()->level === 'Ka.Dept' && Auth::user()->departemen === 'General Affairs')
                <a id="exportExcel" href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#eksporModal">
                    <i class="fas fa-file-export me-1"></i> Export Excel
                </a>
            @endif

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
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $pengeluaranBarang->pengeluaran_barang_id }}</td>
                                <td>{{ $pengeluaranBarang->tujuan_pengeluaran_barang }}</td>
                                <td>{{ $pengeluaranBarang->jenis_kendaraan }}</td>
                                <td>
                                    @if ($pengeluaranBarang->status == 'Level 1')
                                        Menunggu Persetujuan PIC/Ka.Sie
                                    @elseif ($pengeluaranBarang->status == 'Level 2')
                                        PIC/Ka.Sie Sudah Menyetujui
                                    @elseif ($pengeluaranBarang->status == 'Level 3')
                                        Menunggu Persetujuan Ka.Dept GA
                                    @elseif ($pengeluaranBarang->status == 'Level 4')
                                        @if ($pengeluaranBarang->kategori_pengeluaran == 1)
                                        Menunggu Persetujuan Finance
                                        @else
                                        Menunggu Persetujuan Security
                                        @endif
                                    @elseif ($pengeluaranBarang->status == 'Level 5')
                                        Menunggu Persetujuan Security
                                    @elseif ($pengeluaranBarang->status == 'Level 6')
                                        Sudah Disetujui
                                    @elseif ($pengeluaranBarang->status == 'Level 0')
                                        Ditolak
                                    @else
                                        {{ $pengeluaranBarang->status }}
                                    @endif
                                </td>
                                <td>
                                    <div class="button-group d-flex">
                                        @if($user->level === 'Super Admin' && $user->departemen == 'General Affairs')
                                         
                                            <!-- Button Edit -->
                                                <button 
                                                    type="button" 
                                                    class="btn btn-warning btn-sm mr-2" 
                                                    data-toggle="modal" 
                                                    data-target="#editDataModal" 
                                                    data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                        @endif 
                                        <!-- Button for Level 1 (Ka.Sie) -->
                                        @if($pengeluaranBarang->status === 'Level 1' && $user->level === 'Ka.Sie')
                                            
                                            <button 
                                                type="button" 
                                                class="btn btn-success btn-sm mr-2 update-status-kasie" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-check-circle"></i>
                                            </button>

                                            <!-- Button reject -->
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm mr-2 reject-status" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-times-circle"></i>
                                            </button>
                                        @endif
                
                                        <!-- Button for Level 2 (Ka.Dept YBS) -->
                                        @if($pengeluaranBarang->status === 'Level 2' && $user->level === 'Ka.Dept' && $user->departemen !== 'General Affairs')
                                            <button 
                                                type="button" 
                                                class="btn btn-success btn-sm mr-2 update-status-kadeptybs" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-check-circle"></i>
                                            </button>

                                            <!-- Button reject -->
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm mr-2 reject-status" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-times-circle"></i>
                                            </button>

                                        @endif
                
                                        <!-- Button for Level 3 (Ka.Dept GA) -->
                                        @if(
                                            $pengeluaranBarang->status === 'Level 3' &&
                                            $user->level === 'Ka.Dept' &&
                                            $user->departemen === 'General Affairs' &&
                                            $pengeluaranBarang->user->departemen !== 'General Affairs'
                                        )
                                            <button 
                                                type="button" 
                                                class="btn btn-success btn-sm mr-2 update-status-kadeptga" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-check-circle"></i>
                                            </button>

                                            <!-- Button reject -->
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm mr-2 reject-status" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-times-circle"></i>
                                            </button>
                                        @endif

                                        <!-- Tambahan: Jika yang mengajukan adalah dari General Affairs sendiri -->
                                        @if(
                                            $pengeluaranBarang->status === 'Level 2' &&
                                            $pengeluaranBarang->user->departemen === 'General Affairs' &&
                                            $user->level === 'Ka.Dept' &&
                                            $user->departemen === 'General Affairs'
                                        )
                                            <button 
                                                type="button" 
                                                class="btn btn-success btn-sm mr-2 update-status-kadeptga" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-check-circle"></i>
                                            </button>

                                            <!-- Button reject -->
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm mr-2 reject-status" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-times-circle"></i>
                                            </button>
                                        @endif


                                        <!-- Button for finance approval -->
                                        @if($pengeluaranBarang->status === 'Level 4' && $user->departemen === 'Finance' && $pengeluaranBarang->kategori_pengeluaran == 1)
                                            <button 
                                                type="button" 
                                                class="btn btn-success btn-sm mr-2 update-status-finance" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-check-circle"></i>
                                            </button>

                                            <!-- Button reject -->
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm mr-2 reject-status" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-times-circle"></i>
                                            </button>
                                        @endif

                                        

                                        <!-- Button detail -->
                                        <button 
                                            type="button" 
                                            class="btn btn-primary btn-sm mr-2" 
                                            data-toggle="modal" 
                                            data-target="#detailModal" 
                                            data-nomor="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>              
            </div>
        </div>
    </div>

    {{-- Export Excel Modal--}}
    <div class="modal fade" id="eksporModal" tabindex="-1" role="dialog" aria-labelledby="eksporModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Ekspor Barang Keluar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="d-flex mb-3">
                            <input type="text" id="date-range-picker" class="form-control me-2" placeholder="Pilih Rentang Tanggal">

                            <a href="#" id="downloadExcel" class="btn btn-success btn-sm d-flex align-items-center px-3" target="_blank" style="height: 38px;">
                                <i class="fas fa-download me-1"></i> Simpan
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="previewDataEksporModal" class="table table-bordered">
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
                            <tbody id="eksporBody">
                                <!-- Data akan diisi secara dinamis -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    {{-- Detail Modal --}}
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Barang Keluar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <p><strong>Nomor Pengeluaran:</strong> <span id="nomorPengeluaranCard"></span></p>
                        <p><strong>Kategori Pengeluaran:</strong> <span id="kategoriBarangCard"></span></p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p><strong>Nomor Polisi:</strong> <span id="nomorPolisiCard"></span></p>
                    </div>
                    <!-- Card untuk Tabel Barang Keluar -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Informasi Barang Keluar</h6>
                        </div>
                        <div class="card-body">
                            <table id="detaildataTableModal" class="table table-bordered">
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
                            <h6 class="mb-0">Informasi Historis Persetujuan</h6>
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

     {{-- Edit Modal --}}
    <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
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
                            <select class="form-control" id="edit_jenis_kendaraan" name="jenis_kendaraan" required autocomplete="off">
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
                            <input type="text" class="form-control" id="edit_tujuan_pengeluaran_barang" name="tujuan_pengeluaran_barang" required autocomplete="off">
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

    

$(document).ready(function() {
    // Button for Ka.Sie approval
    $('.update-status-kasie').on('click', function() {
        var pengeluaranBarangId = $(this).data('id');
        confirmUpdate(pengeluaranBarangId, '/pengeluaran/update-status-kasie');
    });

    // Button for Ka.Dept YBS approval
    $('.update-status-kadeptybs').on('click', function() {
        var pengeluaranBarangId = $(this).data('id');
        confirmUpdate(pengeluaranBarangId, '/pengeluaran/update-status-kadeptybs');
    });

    // Button for Ka.Dept GA approval
    $('.update-status-kadeptga').on('click', function() {
        var pengeluaranBarangId = $(this).data('id');
        confirmUpdate(pengeluaranBarangId, '/pengeluaran/update-status-kadeptga');
    });

    $('.update-status-finance').on('click', function() {
        var pengeluaranBarangId = $(this).data('id');
        confirmUpdate(pengeluaranBarangId, '/pengeluaran/update-status-finance');
    });

    //Search Lintas Departemen
    const userSingkatan = "{{ Auth::user()->singkatan }}";

    // Inisialisasi DataTable
    const table = $('#dataTable').DataTable({
        responsive: true
    });

     $('#downloadExcel').on('click', function (e) {
        e.preventDefault();

        if (startDate && endDate) {
            const url = `/data-barang-keluar/export?start=${startDate}&end=${endDate}`;
            window.open(url, '_blank');
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Rentang tanggal belum dipilih',
                text: 'Silakan pilih rentang tanggal terlebih dahulu sebelum mengekspor data.',
                confirmButtonText: 'Oke',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        }
    });

    
    let startDate = null;
    let endDate = null;

    $('#eksporModal').on('shown.bs.modal', function () {
        // Inisialisasi flatpickr setiap kali modal ditampilkan (tanpa validasi sekali)
        flatpickr("#date-range-picker", {
            mode: "range",
            dateFormat: "Y-m-d",
            locale: "id",
            defaultDate: null,
            onChange: function (selectedDates) {
                if (selectedDates.length === 2) {
                    startDate = selectedDates[0].toISOString().split('T')[0];
                    endDate = selectedDates[1].toISOString().split('T')[0];
                    console.log("Rentang:", startDate, "hingga", endDate);

                    $.ajax({
                        url: '/pengeluaran/dataBarangRange',
                        method: 'GET',
                        data: {
                            start: startDate,
                            end: endDate,
                        },
                        success: function (response) {
                            const table = $('#previewDataEksporModal').DataTable();

                            // Hapus semua data di DataTable
                            table.clear();

                            if (response.barang_keluar && response.barang_keluar.length > 0) {
                                response.barang_keluar.forEach(function (item, index) {
                                    // Interpretasi status
                                    let statusText = '-';
                                    switch (item.status) {
                                        case 'Level 1':
                                            statusText = 'Menunggu Persetujuan PIC/Ka.Sie';
                                            break;
                                        case 'Level 2':
                                            statusText = 'PIC/Ka.Sie Sudah Menyetujui';
                                            break;
                                        case 'Level 3':
                                            statusText = 'Menunggu Persetujuan Ka.Dept GA';
                                            break;
                                        case 'Level 4':
                                            if (item.kategori_pengeluaran == 1) {
                                                statusText = 'Menunggu Persetujuan Finance';
                                            } else {
                                                statusText = 'Menunggu Persetujuan Security';
                                            }
                                            break;
                                        case 'Level 5':
                                            statusText = 'Menunggu Persetujuan Security';
                                            break;
                                        case 'Level 6':
                                            statusText = 'Sudah Disetujui';
                                            break;
                                        case 'Level 0':
                                            statusText = 'Ditolak';
                                            break;
                                        default:
                                            statusText = item.status || '-';
                                    }

                                    table.row.add([
                                        index + 1,
                                        item.pengeluaran_barang_id || '-',
                                        item.tujuan_pengeluaran_barang || '-',
                                        item.jenis_kendaraan || '-',
                                        statusText,
                                        `<button 
                                            type="button" 
                                            class="btn btn-primary btn-sm" 
                                            data-toggle="modal" 
                                            data-target="#detailModal" 
                                            data-nomor="${item.pengeluaran_barang_id}">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </button>`
                                    ]);
                                });
                            }
                            else {
                                table.row.add([
                                    '', '', '', '', '', 'Data tidak ditemukan'
                                ]);
                            }

                            table.draw();
                        },
                        error: function (xhr, status, error) {
                            alert('Gagal mengambil data: ' + error);
                        }
                    });
                }
            },
        });

        // Inisialisasi DataTable (cek hanya sekali)
        if (!$.fn.DataTable.isDataTable('#previewDataEksporModal')) {
            $('#previewDataEksporModal').DataTable({
                responsive: true,
                autoWidth: false,
                scrollX: false,
                destroy: true, // Optional jika re-init
                retrieve: true // Biarkan reuse jika sudah ada
            });
        }
    });

    // Common function to show confirmation and then update status
    function confirmUpdate(pengeluaranBarangId, url) {
        Swal.fire({
            title: 'Konfirmasi Persetujuan',
            text: 'Apakah Anda menyetujui penngeluaran barang dengan nomor ' + pengeluaranBarangId + '?',
            icon: 'info',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Setuju!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading SweetAlert saat proses berlangsung
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang menyimpan persetujuan Anda.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                updateStatus(pengeluaranBarangId, url);
            }
        });
    }

    // Common function to handle status update
    function updateStatus(pengeluaranBarangId, url) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    pengeluaran_barang_id: pengeluaranBarangId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Success alert using SweetAlert
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Pengeluaran barang dengan no: ' + pengeluaranBarangId + ' telah disetujui.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload(); // Reload the table after successful update
                        });
                    } else {
                        // Error alert using SweetAlert
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(response) {
                    // Handle any error response using SweetAlert
                    Swal.fire({
                        title: 'Error!',
                        text: response.responseJSON.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        $('#detailModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget); // Button yang diklik
            const nomor = button.data('nomor'); // Nomor pengeluaran barang
            document.getElementById('nomorPengeluaranCard').innerText = nomor;

            $.ajax({
                url: "/pengeluaran/detail",
                method: "POST",
                data: { pengeluaran_barang_id: nomor, "_token": "{{ csrf_token() }}" },
                success: function (data) {
                    document.getElementById('kategoriBarangCard').innerText = data.kategori_pengeluaran === 1 ? 'Scrap' : 'Non Scrap';
                    document.getElementById('nomorPolisiCard').innerText = data.no_polisi || '-';
                    const detailTable = $('#detaildataTableModal').DataTable();

                    // Kosongkan data lama
                    detailTable.clear();
                    document.getElementById('additionalInfoBody').innerHTML = ""; // Kosongkan tabel Informasi Tambahan

                    // Validasi data barang_keluar
                    if (data.barang_keluar && data.barang_keluar.length > 0) {
                        let newData = data.barang_keluar.map((item, index) => [
                            index + 1,
                            nomor,
                            item.nama_barang,
                            item.jumlah_barang,
                            item.satuan_barang,
                            item.keterangan_barang
                        ]);
                        detailTable.rows.add(newData).draw();
                    } else {
                        detailTable.rows.add([["", "", "Tidak ada data barang keluar", "", "", ""]]).draw();
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
                        "Level 0":"Menolak",
                        "Level 1": "Mengeluarkan",
                        "Level 2": "Membawa",
                        "Level 3": "Menyetujui",
                        "Level 4": "Mengetahui",
                        "Level 5": "Menerima",
                        "Level 6": "Memeriksa"
                    };

                    // Validasi data informasi_tambahan
                    const additionalInfoBody = document.getElementById('additionalInfoBody');

                    if (data.informasi_tambahan && data.informasi_tambahan.length > 0) {
                        data.informasi_tambahan.forEach((info, index) => {
                            let row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${info.nama}</td>
                                    <td>${tingkatMapping[info.tingkatan] || info.tingkatan}</td>
                                    <td>${info.departemen}</td>
                                    <td>${approvMapping[info.status] || info.status}</td>
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

                    // Pastikan modal terbuka setelah data dimuat
                    $('#detailModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data:", error);
                    alert("Terjadi kesalahan saat mengambil data.");
                }
            });
        });

        // Inisialisasi DataTable hanya untuk tabel barang keluar
        if (!$.fn.DataTable.isDataTable('#detaildataTableModal')) {
            $('#detaildataTableModal').DataTable({
                responsive: true,
                autoWidth: false,
                scrollX: false,
                destroy: true,
                retrieve: true,
                pageLength: 5, // Menentukan jumlah default entries per page menjadi 5
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]] 
            });
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
        $('.select-tools').selectize({
            create: true, // Memungkinkan pengguna menambahkan opsi baru
            sortField: 'text' // Mengurutkan opsi berdasarkan teks
        });

        // Handle click event on update status button
        document.querySelectorAll('.reject-status').forEach(button => {
            button.addEventListener('click', function () {
                const pengeluaranBarangId = this.getAttribute('data-id');

                // Konfirmasi menggunakan SweetAlert
                Swal.fire({
                    title: 'Tolak Pengajuan',
                    text: 'Apakah Anda yakin ingin menolak pengeluaran barang dengan nomor ' + pengeluaranBarangId + '?',
                    icon: 'error',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan loading modal setelah klik "Ya, tolak!"
                        Swal.fire({
                            title: 'Menolak Pengajuan...',
                            html: 'Mohon tunggu, sedang memproses penolakan.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        fetch("{{ route('approval.rejectStatus') }}", {
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
                                    showConfirmButton: false,
                                    timer: 2000
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

    $('#editDataModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); 
        const pengeluaranBarangId = button.data('id'); 


        $('#edit_pengeluaran_barang_id').val('');
        $('#edit_jenis_kendaraan').val('');
        $('#edit_lokasi_barang_keluar').val('');
        $('#edit_tujuan_pengeluaran_barang').val('');
        $('#editBarangTable tbody').empty();

        
        $.ajax({
            url: `/pengeluaran/edit`, 
            method: 'POST',
            data: {
                pengeluaran_barang_id: pengeluaranBarangId,
                "_token": "{{ csrf_token() }}" // CSRF Token
            },
            success: function (response) {
                
                $('#edit_pengeluaran_barang_id').val(response.pengeluaran_barang_id);
                $('#edit_jenis_kendaraan').val(response.jenis_kendaraan);
                $('#edit_lokasi_barang_keluar').val(response.lokasi_barang_keluar);
                $('#edit_tujuan_pengeluaran_barang').val(response.tujuan_pengeluaran_barang);

                const tableBody = $('#editBarangTable tbody');
                response.barangKeluar.forEach((barang, index) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>
                                <input type="hidden" name="barang_ids[]" value="${barang.barang_keluar_id || ''}">
                                <input type="text" name="nama_barang[]" class="form-control" value="${barang.nama_barang}" required autocomplete="off">
                            </td>
                            <td><input type="number" name="jumlah[]" class="form-control" value="${barang.jumlah_barang}" min="1" required autocomplete="off"></td>
                            <td>
                                <select name="satuan[]" class="form-control" required>
                                    <option value="" disabled>Pilih Satuan</option>
                                    <option value="unit" ${barang.satuan_barang === 'unit' ? 'selected' : ''}>Unit</option>
                                    <option value="pcs" ${barang.satuan_barang === 'pcs' ? 'selected' : ''}>PCS</option>
                                </select>
                            </td>
                            <td><input type="text" name="keterangan[]" class="form-control" value="${barang.keterangan_barang}" required autocomplete="off"></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBoxEdit(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>`;
                    tableBody.append(row);
                });
            },
            error: function (xhr, status, error) {
                console.error(`Error: ${error}`);
                alert('Gagal mengambil data. Silakan coba lagi.');
            }
        });
    });


    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable({
                columnDefs: [
                    { className: 'dt-body-center', targets: 0 },
                    { className: 'dt-head-center', targets: 0 },
                    { className: 'dt-body-center', targets: 5 },
                    { className: 'dt-head-center', targets: 5 }
                ],
                scrollX: false,
                responsive: true
            });
        }
    });



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