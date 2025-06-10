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

    <style>
        .custom-input,
        .custom-select {
            border-radius: 0.375rem; /* Sama dengan rounded-md Bootstrap */
            border: 1px solid #ced4da;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            background-color: #fff;
        }

        .custom-input:focus,
        .custom-select:focus {
            border-color: #5A6ACF;
            box-shadow: 0 0 0 0.2rem rgba(90, 106, 207, 0.25);
            outline: none;
        }

        /* Untuk readonly input agar tampil mirip disabled select */
       input[readonly].custom-input {
            background-color: #f8f9fa; /* Tetap terang */
            color: #6c757d;            /* Abu-abu redup */
            cursor: not-allowed;
        }


        /* Jika input berada dalam tabel */
        td .custom-input,
        td .custom-select {
            margin: 0;  /* Hindari spasi aneh di tabel */
        }
    </style>

    <div class="container-fluid">

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center" style="border-top: 5px solid #5A6ACF;">
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
                            <th>Jenis Kendaraan</th>
                            <th>Nomor Kendaraan</th>
                            <th>Kapasitas Kendaraan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kendaraanDinas as $index => $kendaraan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @php
                                        $jenisKendaraan = [
                                            1 => 'KANTOR',
                                            2 => 'PRIBADI',
                                            3 => 'TAXI'
                                        ];
                                    @endphp
                                    {{ $jenisKendaraan[$kendaraan->jenis_kendaraan] ?? 'Tidak Diketahui' }}
                                </td>
                                <td>{{ $kendaraan->nomor_kendaraan }}</td>
                                <td>{{ $kendaraan->kapasitas_kendaraan }} Penumpang</td>
                                <td>
                                    @if ($kendaraan->status_kendaraan == 1)
                                        <span class="badge badge-success">Tersedia</span>
                                    @else
                                        <span class="badge badge-danger">Tidak Tersedia</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="{{ $kendaraan->kendaraan_dinas_id }}">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </button>
                                    <!-- Button Edit -->
                                    <button 
                                        type="button" 
                                        class="btn btn-warning btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#editDataModal" 
                                        data-id="{{ $kendaraan->kendaraan_dinas_id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Button reject -->
                                    <button 
                                        type="button" 
                                        class="btn btn-danger btn-sm mr-2 reject-status" 
                                        data-id="{{ $kendaraan->kendaraan_dinas_id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>         
            </div>
        </div>
    </div>
    

    <!-- Modal Kalender Umum -->
    <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="max-width: 95%;">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="calendarModalLabel">Kalender Booking Seluruh Kendaraan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label for="monthPickerGlobal">Pilih Bulan:</label>
                <input type="month" id="monthPickerGlobal" class="form-control" style="max-width: 250px;">
            </div>
            <div id="calendarAllKendaraan"></div>
            </div>
        </div>
        </div>
    </div>
  
      

    {{-- Tambah Modal --}}
    <div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Pengeluaran Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('kendaraan.store')}}" enctype="multipart/form-data" id="tambah_pengeluaran_barang">
                        @csrf
    
                        <div class="form-group">
                            <label for="merk_kendaraan">Merk Kendaraan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="merk_kendaraan" name="merk_kendaraan" required autocomplete="off">
                        </div>  

                        <div class="form-group">
                            <label for="jenis_kendaraan">Jenis Kendaraan <span class="text-danger">*</span></label>
                            <select class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" required autocomplete="off">
                                <option value="" disabled selected>Pilih Jenis Kendaraan</option>
                                <option value="1">KANTOR</option>
                                <option value="2">PRIBADI</option>
                                <option value="3">TAXI</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nomor_kendaraan">No Polisi <span class="text-danger">*</span></label>
                            
                            <!-- License Plate Separated Fields -->
                            <div class="license-plate-container" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <input type="text" 
                                    class="custom-input" 
                                    id="area_code" 
                                    name="area_code" 
                                    placeholder="B" 
                                    maxlength="2"
                                    style="width: 60px; text-align: center; text-transform: uppercase;"
                                    required>
                                
                                <span style="font-size: 18px; color: #666;">-</span>
                                
                                <input type="text" 
                                    class="custom-input" 
                                    id="number_part" 
                                    name="number_part" 
                                    placeholder="1234" 
                                    maxlength="4"
                                    style="width: 80px; text-align: center;"
                                    required>
                                
                                <span style="font-size: 18px; color: #666;">-</span>
                                
                                <input type="text" 
                                    class="custom-input" 
                                    id="letter_code" 
                                    name="letter_code" 
                                    placeholder="ACD" 
                                    maxlength="3"
                                    style="width: 70px; text-align: center; text-transform: uppercase;"
                                    required>
                            </div>
                            
                            <!-- Hidden input for complete license plate -->
                            <input type="hidden" id="nomor_kendaraan" name="nomor_kendaraan" value="">
                            
                            <!-- Error message -->
                            <small id="nomor_kendaraan_error" class="text-danger" style="display: none;">
                                Mohon lengkapi semua bagian nomor polisi dengan benar.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="kapasitas_kendaraan">Kapasitas Kendaraan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control input-kapasitas" id="kapasitas_kendaraan" name="kapasitas_kendaraan" min="1" placeholder="Masukan Kapasitas Kendaraan" required autocomplete="off">
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

    {{-- Edit Modal --}}
    <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Edit Data Pengeluaran Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('kendaraan.update') }}" enctype="multipart/form-data" id="editForm">
                        @csrf
                        @method('PUT')
        
                        <input type="hidden" name="kendaraan_dinas_id" id="edit_kendaraan_dinas_id">

                        <div class="form-group">
                            <label for="merk_kendaraan">Merk Kendaraan <span class="text-danger">*</span></label>
                            <input type="custom-input" class="form-control" id="edit_merk_kendaraan" name="merk_kendaraan" required autocomplete="off">
                        </div> 
        
                        <div class="form-group">
                            <label for="jenis_kendaraan">Jenis Kendaraan <span class="text-danger">*</span></label>
                            <select class="form-control" id="edit_jenis_kendaraan" name="jenis_kendaraan" required autocomplete="off">
                                <option value="" disabled selected>Pilih Jenis Kendaraan</option>
                                <option value="1">KANTOR</option>
                                <option value="2">PRIBADI</option>
                                <option value="3">TAXI</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="nomor_kendaraan">No Polisi <span class="text-danger">*</span></label>
                            
                            <!-- License Plate Separated Fields -->
                            <div class="license-plate-container" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <input type="text" 
                                    class="custom-input" 
                                    id="edit_area_code" 
                                    name="edit_area_code" 
                                    placeholder="B" 
                                    maxlength="2"
                                    style="width: 60px; text-align: center; text-transform: uppercase;"
                                    required>
                                
                                <span style="font-size: 18px; color: #666;">-</span>
                                
                                <input type="text" 
                                    class="custom-input" 
                                    id="edit_number_part" 
                                    name="edit_number_part" 
                                    placeholder="1234" 
                                    maxlength="4"
                                    style="width: 80px; text-align: center;"
                                    required>
                                
                                <span style="font-size: 18px; color: #666;">-</span>
                                
                                <input type="text" 
                                    class="custom-input" 
                                    id="edit_letter_code" 
                                    name="edit_letter_code" 
                                    placeholder="ACD" 
                                    maxlength="3"
                                    style="width: 70px; text-align: center; text-transform: uppercase;"
                                    required>
                            </div>
                            
                            <!-- Hidden input for complete license plate -->
                            <input type="hidden" id="edit_nomor_kendaraan" name="nomor_kendaraan" value="">
                            
                            <!-- Error message -->
                            <small id="edit_nomor_kendaraan_error" class="text-danger" style="display: none;">
                                Mohon lengkapi semua bagian nomor polisi dengan benar.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="kapasitas_kendaraan">Kapasitas Kendaraan <span class="text-danger">*</span></label>
                            <input type="custom-input number" class="form-control input-kapasitas" id="edit_kapasitas_kendaraan" name="kapasitas_kendaraan" min="1" placeholder="Masukan Kapasitas Kendaraan" required autocomplete="off">
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

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Riwayat Penggunaan Kendaraan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="tableRiwayat">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Surat Dians</th>
                                <th>Rute</th>
                                <th>Tanggal Penggunaan</th>
                                <th>Status Persetujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimasukkan lewat JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    let globalCalendar;
    
    $('#calendarModal').on('show.bs.modal', function () {
      $.get(`/kendaraan/booking-dates-all`, function (data) {
        const events = data.map(item => ({
          title: item.merk_kendaraan + ' - ' + item.nomor_kendaraan,
          start: item.tanggal_penggunaan,
          allDay: true,
          backgroundColor: '#28a745',
          borderColor: '#28a745'
        }));
    
        if (globalCalendar) globalCalendar.destroy();
    
        const calendarEl = document.getElementById('calendarAllKendaraan');
        globalCalendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          height: 450,
          events: events,
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth'
          }
        });
    
        globalCalendar.render();
    
        // Inisialisasi input bulan
        const currentDate = globalCalendar.getDate();
        $('#monthPickerGlobal').val(currentDate.toISOString().slice(0, 7));
    
        $('#monthPickerGlobal').on('change', function () {
          const selected = this.value;
          if (selected) {
            const newDate = selected + "-01";
            globalCalendar.gotoDate(newDate);
          }
        });
      });
    });
</script>
    
<script>

    $('#detailModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const kendaraanId = button.data('id');

        // Hancurkan instance DataTable sebelumnya (jika ada)
        if ($.fn.DataTable.isDataTable('#tableRiwayat')) {
            $('#tableRiwayat').DataTable().clear().destroy();
        }

        $.get(`/kendaraan/${kendaraanId}/riwayat-surat`, function (data) {
            const tbody = $('#tableRiwayat tbody');
            tbody.empty();

            if (data.length === 0) {
                tbody.append('<tr><td colspan="7" class="text-center">Tidak ada riwayat penggunaan.</td></tr>');
                // Jika data kosong, tidak perlu menginisialisasi DataTable
            } else {
                data.forEach((item, index) => { 
                    let statusLabel = '';

                    if (item.status === 'Level 1') {
                        statusLabel = 'Menunggu Persetujuan Ka.Dept';
                    } else if (item.status === 'Level 2') {
                        statusLabel = 'Menunggu Persetujuan Ka.Sie Transportasi';
                    } else if (item.status === 'Level 3') {
                        statusLabel = 'Menunggu Persetujuan Security';
                    } else if (item.status === 'Level 4') {
                        statusLabel = 'Sudah Disetujui';
                    } else if (item.status === 'Level 0') {
                        statusLabel = 'Ditolak';
                    } else {
                        statusLabel = item.status;
                    }

                    tbody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.surat_kendaraan_dinas_id}</td>
                            <td>${item.tujuan_penggunaan}</td>
                            <td>${item.tanggal_penggunaan}</td>
                            <td>${statusLabel}</td>
                        </tr>
                    `);
                });
                
                // Inisialisasi DataTable hanya jika ada data
                $('#tableRiwayat').DataTable({
                    columnDefs: [
                        { className: 'dt-head-center', targets: 0 },
                        { className: 'dt-head-center', targets: 1 },
                        { className: 'dt-head-center', targets: 2 },
                        { className: 'dt-head-center', targets: 3 },
                        { className: 'dt-head-center', targets: 4 },

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
                    lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                });
            }
        });
    });




    $('#editDataModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const kendaraanId = button.data('id'); 

        // Kosongkan field sebelum diisi ulang
        $('#edit_kendaraan_dinas_id').val('');
        $('#edit_merk_kendaraan').val('');
        $('#edit_jenis_kendaraan').val('');
        $('#edit_nomor_kendaraan').val('');
        $('#edit_kapasitas_kendaraan').val('');

    
        // Panggil data dari server
        $.ajax({
            url: `/kendaraan/edit`,  // Gunakan metode GET
            method: 'GET',
            data: {
                kendaraan_dinas_id: kendaraanId,
                "_token": "{{ csrf_token() }}" // CSRF Token
            },
            success: function (response) {
                $('#edit_kendaraan_dinas_id').val(response.kendaraan_dinas_id);
                $('#edit_merk_kendaraan').val(response.merk_kendaraan);
                $('#edit_jenis_kendaraan').val(response.jenis_kendaraan);
                $('#edit_kapasitas_kendaraan').val(response.kapasitas_kendaraan);

                // Parse license plate and populate separated fields
                const licenseParts = parseLicensePlate(response.nomor_kendaraan);
                $('#edit_area_code').val(licenseParts.area);
                $('#edit_number_part').val(licenseParts.number);
                $('#edit_letter_code').val(licenseParts.letter);
                
                // Update hidden field
                $('#edit_nomor_kendaraan').val(response.nomor_kendaraan);
            },
            error: function (xhr, status, error) {
                console.error(`Error: ${error}`);
                alert('Gagal mengambil data. Silakan coba lagi.');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.reject-status').forEach(button => {
            button.addEventListener('click', function () {
                const kendaraanId = this.getAttribute('data-id');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan menonaktifkan kendaraan dinas!",
                    icon: 'info',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, nonaktifkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('kendaraan.nonAktif') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken
                            },
                            body: JSON.stringify({ kendaraan_dinas_id: kendaraanId })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload(); // Reload halaman setelah berhasil
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
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


    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable({
                columnDefs: [
                    { className: 'dt-head-center', targets: 0 },
                    { className: 'dt-head-center', targets: 1 },
                    { className: 'dt-head-center', targets: 2 },
                    { className: 'dt-head-center', targets: 3 },
                    { className: 'dt-head-center', targets: 4 },
                    { className: 'dt-head-center', targets: 5 },

                    { className: 'dt-body-center', targets: 0 },
                    { className: 'dt-body-center', targets: 5 }
                    
                ],
                scrollX: false,
                responsive: true
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Handle Add Modal License Plate Fields
        setupLicensePlateFields('area_code', 'number_part', 'letter_code', 'nomor_kendaraan', 'nomor_kendaraan_error', 'tambahDataModal');
        
        // Handle Edit Modal License Plate Fields
        setupLicensePlateFields('edit_area_code', 'edit_number_part', 'edit_letter_code', 'edit_nomor_kendaraan', 'edit_nomor_kendaraan_error', 'editForm');
    });

    // Function to setup license plate fields (reusable for both modals)
    function setupLicensePlateFields(areaId, numberId, letterId, hiddenId, errorId, formId) {
        const areaCode = document.getElementById(areaId);
        const numberPart = document.getElementById(numberId);
        const letterCode = document.getElementById(letterId);
        const hiddenInput = document.getElementById(hiddenId);
        const errorMsg = document.getElementById(errorId);

        // Function to update hidden input
        function updateHiddenInput() {
            const area = areaCode.value.toUpperCase().trim();
            const number = numberPart.value.trim();
            const letter = letterCode.value.toUpperCase().trim();
            
            // Update hidden input only if all fields are filled
            if (area && number && letter) {
                const fullPlate = `${area} ${number} ${letter}`;
                hiddenInput.value = fullPlate;
                errorMsg.style.display = 'none';
            } else {
                hiddenInput.value = '';
            }
        }

        // Validation and auto-focus for area code (letters only)
        areaCode.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^A-Za-z]/g, '').toUpperCase();
            updateHiddenInput();
            
            // Auto focus to next field when max length reached
            if (e.target.value.length === 2) {
                numberPart.focus();
            }
        });

        // Validation and auto-focus for number part (numbers only)
        numberPart.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
            updateHiddenInput();
            
            // Auto focus to next field when max length reached
            if (e.target.value.length === 4) {
                letterCode.focus();
            }
        });

        // Validation for letter code (letters only)
        letterCode.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^A-Za-z]/g, '').toUpperCase();
            updateHiddenInput();
        });

        // Handle backspace for auto focus to previous field
        [areaCode, numberPart, letterCode].forEach((input, index) => {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                    const prevInput = [areaCode, numberPart, letterCode][index - 1];
                    prevInput.focus();
                }
            });
        });

        // Form validation before submit
        const form = document.getElementById(formId);
        if (form) {
            // Override the default validation to include license plate check
            const originalCheckValidity = form.checkValidity;
            form.checkValidity = function() {
                const area = areaCode.value.trim();
                const number = numberPart.value.trim();
                const letter = letterCode.value.trim();
                
                // Check if license plate is complete
                if (!area || !number || !letter) {
                    errorMsg.style.display = 'block';
                    errorMsg.textContent = 'Mohon lengkapi semua bagian nomor polisi.';
                    
                    // Focus on first empty field
                    if (!area) areaCode.focus();
                    else if (!number) numberPart.focus();
                    else if (!letter) letterCode.focus();
                    
                    return false;
                } else {
                    errorMsg.style.display = 'none';
                    // Call original checkValidity for other form elements
                    return originalCheckValidity.call(this);
                }
            };
        }

        // Initial update
        updateHiddenInput();
    }

    // Function to parse license plate string into parts
    function parseLicensePlate(licensePlate) {
        if (!licensePlate) return { area: '', number: '', letter: '' };
        
        // Parse format like "B 1234 ACD" or "AB 123 C"
        const parts = licensePlate.trim().split(/\s+/);
        
        if (parts.length === 3) {
            return {
                area: parts[0],
                number: parts[1],
                letter: parts[2]
            };
        }
        
        return { area: '', number: '', letter: '' };
    }

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('input-kapasitas')) {
            // Ambil angka, hapus karakter non-digit
            let val = e.target.value.replace(/\D/g, '');

            // Hapus semua 0 di depan, tapi tetap izinkan angka '0' tunggal
            if (val.length > 1) {
                val = val.replace(/^0+/, '');
            }

            // Jika hanya 0 saja, kosongkan (tidak valid)
            if (val === '0') val = '';

            // Maksimal 2 digit
            e.target.value = val.slice(0, 2);
        }
    });

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    var $select = $('#select-tools').selectize({
    
    create: true
    });

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
