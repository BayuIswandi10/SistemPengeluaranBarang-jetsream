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
                            <label for="nomor_kendaraan">Nomor Kendaraan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nomor_kendaraan" name="nomor_kendaraan" required autocomplete="off">
                        </div>  

                        <div class="form-group">
                            <label for="kapasitas_kendaraan">Kapasitas Kendaraan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="kapasitas_kendaraan" name="kapasitas_kendaraan" min="1" placeholder="Masukan Kapasitas Kendaraan" required autocomplete="off">
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
                            <input type="text" class="form-control" id="edit_merk_kendaraan" name="merk_kendaraan" required autocomplete="off">
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
                            <label for="nomor_kendaraan">Nomor Kendaraan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nomor_kendaraan" name="nomor_kendaraan" required autocomplete="off">
                        </div>  

                        <div class="form-group">
                            <label for="kapasitas_kendaraan">Kapasitas Kendaraan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_kapasitas_kendaraan" name="kapasitas_kendaraan" min="1" placeholder="Masukan Kapasitas Kendaraan" required autocomplete="off">
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
                                <th>ID Surat</th>
                                <th>Tujuan Penggunaan</th>
                                <th>Tanggal Penggunaan</th>
                                <th>Status</th>
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
                        { className: 'dt-body-center', targets: 0 },
                        { className: 'dt-head-center', targets: 0 },
                        { className: 'dt-body-center', targets: 4 },
                        { className: 'dt-head-center', targets: 4 }
                    ],
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
                $('#edit_nomor_kendaraan').val(response.nomor_kendaraan);
                $('#edit_kapasitas_kendaraan').val(response.kapasitas_kendaraan);
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
