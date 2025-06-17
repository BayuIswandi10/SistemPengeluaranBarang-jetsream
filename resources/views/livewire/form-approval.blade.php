<div class ="content-wrapper">
    <style>
        /* Pastikan modal tidak lebih besar dari layar */
        @media (max-width: 768px) {
            .modal-dialog {
                max-width: 95%;
                margin: 1.75rem auto;
            }
        }

        /* FIXED: Proper checkbox alignment - vertical and horizontal center */
        #dataTable th:first-child,
        #dataTable td:first-child {
            text-align: center !important;
            vertical-align: middle !important;
            width: 50px !important;
            padding: 8px !important; /* Add consistent padding */
        }

        /* FIXED: Center the checkbox input itself and increase size */
        #dataTable th:first-child .form-check-input,
        #dataTable td:first-child .form-check-input {
            margin: 0 auto !important;
            display: block !important;
            position: relative !important;
            top: 0 !important;
            left: 0 !important;
            transform: none !important;
            width: 20px !important; /* Increased checkbox size */
            height: 20px !important; /* Increased checkbox size */
            transform: scale(1.5); /* Scale for better visibility */
        }

        /* FIXED: Ensure all body cells are vertically centered */
        #dataTable td {
            vertical-align: middle !important;
            line-height: 1.4 !important; /* Ganti dari 1 ke 1.4 agar lebih proporsional */
            word-break: break-word !important; /* Supaya teks panjang bisa pindah baris */
            white-space: normal !important; /* Izinkan teks pindah baris */
        }

        
        /* Khusus kolom terakhir (Detail), center juga */
        #dataTable th:last-child,
        #dataTable td:last-child {
            text-align: center !important;
            vertical-align: middle !important;
        }

        /* Additional fix for form-check wrapper if it exists */
        #dataTable td:first-child .form-check {
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        /* Pastikan isi modal bisa di-scroll jika terlalu panjang */
        .modal-body {
            overflow-x: auto;
        }

        #dataTable {
        opacity: 0;
        transition: opacity 0.3s ease;
        }
        #dataTable.visible {
        opacity: 1;
        }

        .button-group.d-flex {
            justify-content: center;
        }

    </style>
    <div class="container-fluid">

        <div class="card mt-3">
            <div class="card-header" style="border-top: 5px solid #5A6ACF; display: flex; align-items: center; padding: 0.75rem 1.25rem;">
                <h5 class="m-0 font-weight-bold" style="flex-grow: 1; color: #5A6ACF;" >Data Persetujuan</h5>

                <div class="d-flex align-items-center" style="margin-left: auto; gap: 0.5rem;">
                  <input type="text" id="date-range-picker" class="form-control" placeholder="Pilih Rentang Tanggal" style="max-width: 220px;">

                    @if(Auth::check() && Auth::user()->level === 'Ka.Dept' && Auth::user()->departemen === 'GENERAL AFFAIRS')
                        <a href="#" id="downloadExcel"
                        class="btn btn-success btn-sm d-flex align-items-center px-3"
                        style="height: 38px; white-space: nowrap;">
                        <i class="fas fa-file-excel fa-lg mr-2"></i>
                        <span>Export Excel</span>
                        </a>

                    @endif
                </div>
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
                            <th class="text-center">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>NO</th>
                            <th>Nomor Pengeluaran Barang</th>
                            <th>Tujuan</th>
                            <th>Jenis Kendaraan</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 0; ?>
                        @foreach ($pengeluaranBarangs as $pengeluaranBarang)
                            <tr>
                                <td class="text-center">
                                    @php
                                        $canApprove = false;
                                        // Check if current user can approve this item
                                        
                                        // Ka.Sie dapat approve Level 1
                                        if ($pengeluaranBarang->status === 'Level 1' && $user->level === 'Ka.Sie') {
                                            $canApprove = true;
                                        }
                                        
                                        // Ka.Dept YBS dapat approve Level 2 (kecuali dari GENERAL AFFAIRS)
                                        elseif ($pengeluaranBarang->status === 'Level 2' && $user->level === 'Ka.Dept' && $user->departemen !== 'GENERAL AFFAIRS') {
                                            $canApprove = true;
                                        }
                                        
                                        // Ka.Dept GA dapat approve Level 3 (dari departemen lain)
                                        elseif ($pengeluaranBarang->status === 'Level 3' && $user->level === 'Ka.Dept' && $user->departemen === 'GENERAL AFFAIRS' && $pengeluaranBarang->user->departemen !== 'GENERAL AFFAIRS') {
                                            $canApprove = true;
                                        }
                                        
                                        // Ka.Dept GA dapat approve Level 2 (dari GENERAL AFFAIRS sendiri)
                                        elseif ($pengeluaranBarang->status === 'Level 2' && $pengeluaranBarang->user->departemen === 'GENERAL AFFAIRS' && $user->level === 'Ka.Dept' && $user->departemen === 'GENERAL AFFAIRS') {
                                            $canApprove = true;
                                        }
                                        
                                        // Finance dapat approve Level 4 (kategori 1)
                                        elseif ($pengeluaranBarang->status === 'Level 4' && $user->departemen === 'FINANCE' && $pengeluaranBarang->kategori_pengeluaran == 1) {
                                            $canApprove = true;
                                        }
                                        
                                        // Security dapat approve Level 4 (kategori selain 1) dan Level 5
                                        elseif (($pengeluaranBarang->status === 'Level 4' && $user->level === 'Security' && $pengeluaranBarang->kategori_pengeluaran != 1) || 
                                                ($pengeluaranBarang->status === 'Level 5' && $user->level === 'Security')) {
                                            $canApprove = true;
                                        }
                                    @endphp
                                    
                                    @if($canApprove)
                                        <input type="checkbox" 
                                            class="form-check-input item-checkbox" 
                                            value="{{ $pengeluaranBarang->pengeluaran_barang_id }}"
                                            data-status="{{ $pengeluaranBarang->status }}"
                                            data-dept="{{ $pengeluaranBarang->user->departemen }}">
                                    @endif
                                </td>
                                <td>{{ ++$i }}</td>
                                <td>{{ $pengeluaranBarang->pengeluaran_barang_id }}</td>
                                <td>{{ $pengeluaranBarang->tujuan_pengeluaran_barang }}</td>
                                <td>{{ $pengeluaranBarang->jenis_kendaraan }}</td>
                                <td>
                                    @if ($pengeluaranBarang->status == 'Level 1')
                                        Menunggu Persetujuan PIC/Ka.Sie
                                    @elseif ($pengeluaranBarang->status == 'Level 2')
                                        @if ($pengeluaranBarang->user->departemen === 'GENERAL AFFAIRS')
                                            PIC/Ka.Sie Sudah Menyetujui - Menunggu Ka.Dept GA
                                        @else
                                            PIC/Ka.Sie Sudah Menyetujui - Menunggu Ka.Dept YBS
                                        @endif
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
                                        <!-- Button Edit - Only for Super Admin with GA department -->
                                        @if(in_array($pengeluaranBarang->status, ['Level 1', 'Level 2', 'Level 3']) 
                                            && $user->level === 'Super Admin' 
                                            && $user->departemen === 'GENERAL AFFAIRS')

                                            <button 
                                                type="button" 
                                                class="btn btn-warning btn-sm mr-2" 
                                                data-toggle="modal" 
                                                data-target="#editDataModal" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                        
                                        <!-- Button Detail -->
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

            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <div id="selected-info" class="text-muted">
                            <span id="selected-count">0</span> item dipilih
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" 
                                id="bulk-approve-btn" 
                                class="btn btn-success mr-2" 
                                disabled>
                            <i class="fa-solid fa-check-circle mr-1"></i>
                            Setujui
                        </button>
                        
                        <button type="button" 
                                id="bulk-reject-btn" 
                                class="btn btn-danger" 
                                disabled>
                            <i class="fa-solid fa-times-circle mr-1"></i>
                            Tolak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    {{-- Detail Modal --}}
     <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" id="modalHeader" style="position: relative;">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h5 class="modal-title" id="detailModalLabel">Detail Barang Keluar</h5>
                    </div>
                    <div style="position: absolute; right: 50px; top: 50%; transform: translateY(-50%); display: flex; align-items: center; gap: 10px;">
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
                    <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Informasi Tambahan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="additionalInfoTable" class="table table-bordered">
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

@script
<script>
    let dataTableInstance;

   Livewire.on('dataUpdated', () => {
        console.log('dataUpdated event received!');
        setTimeout(() => {
            initDataTable();
        }, 100); // delay 100ms, bisa disesuaikan
    });


   function initDataTable() {
        const table = $('#dataTable');

        // sembunyikan dulu
        table.removeClass('visible');

        if (dataTableInstance) {
            dataTableInstance.destroy();
        }

        dataTableInstance = table.DataTable({
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
            columnDefs: [
            {
                className: 'dt-body-center dt-head-center', 
                targets: 0, // Kolom pertama (checkbox)
                orderable: false, // Opsional: Matikan sorting untuk kolom checkbox
                width: '50px'
            },
                { className: 'dt-head-center', targets: 1 },
                { className: 'dt-head-center', targets: 6 },

                { className: 'dt-body-center', targets: 1 },
                { className: 'dt-body-center', targets: 6 }
            ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            scrollX: false,
            responsive: true,
            order: [[1, 'asc']],
            initComplete: function() {
                // tampilkan setelah selesai inisialisasi
                table.addClass('visible');

                // Update button states after table initialization
                updateBulkActionButtons();

                // Reattach select all checkbox event
                const selectAllCheckbox = document.getElementById('selectAll');
                selectAllCheckbox.addEventListener('change', function() {
                    const isChecked = this.checked;
                    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                        checkbox.checked = isChecked;
                    });
                    updateBulkActionButtons();
                });
            }
        });
        // Use event delegation for checkbox changes
        table.on('change', '.item-checkbox', function() {
            updateSelectAllState();
            updateBulkActionButtons();
        });
    }

    // Update Select All state based on individual checkboxes
    function updateSelectAllState() {
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const totalCheckboxes = itemCheckboxes.length;
        const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked').length;

        const selectAllCheckbox = document.getElementById('selectAll');
        if (checkedCheckboxes === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (checkedCheckboxes === totalCheckboxes) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
            selectAllCheckbox.checked = false;
        }
    }

    // Update bulk action buttons state
    function updateBulkActionButtons() {
        const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked').length;
        const selectedCountElement = document.getElementById('selected-count');
        const bulkApproveBtn = document.getElementById('bulk-approve-btn');
        const bulkRejectBtn = document.getElementById('bulk-reject-btn');

        selectedCountElement.textContent = checkedCheckboxes;
        const hasSelection = checkedCheckboxes > 0;
        bulkApproveBtn.disabled = !hasSelection;
        bulkRejectBtn.disabled = !hasSelection;
    }

    function formatDate(date) {
        const wibOffset = 7 * 60; // offset WIB dalam menit
        const localTime = new Date(date.getTime() + (wibOffset - date.getTimezoneOffset()) * 60000);

        const year = localTime.getFullYear();
        const month = String(localTime.getMonth() + 1).padStart(2, '0');
        const day = String(localTime.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }

    const today = new Date();
    // Awal bulan sebelumnya
    const defaultStartDate = new Date(today.getFullYear(), today.getMonth() - 1, 1, 0, 0, 0);
    // Akhir bulan ini
    const defaultEndDate = new Date(today.getFullYear(), today.getMonth() + 1, 0, 23, 59, 59);

    // Format tanggal (YYYY-MM-DD)
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Inisialisasi flatpickr
    const fp = flatpickr("#date-range-picker", {
        mode: "range",
        dateFormat: "Y-m-d",
        locale: "id",
        rangeSeparator: " sampai ",
        defaultDate: [defaultStartDate, defaultEndDate],
        onClose: function (selectedDates) {
            if (selectedDates.length === 2) {
                startDate = formatDate(selectedDates[0]);
                endDate = formatDate(selectedDates[1]);
            } else {
                startDate = formatDate(defaultStartDate);
                endDate = formatDate(defaultEndDate);
                fp.setDate([defaultStartDate, defaultEndDate]);
            }

            this.input.value = `${startDate} s/d ${endDate}`;
            @this.set('startDate', startDate);
            @this.set('endDate', endDate);
            @this.call('updateDateRange', { startDate, endDate });
        }
    });

    // Atur nilai awal saat load
    startDate = formatDate(defaultStartDate);
    endDate = formatDate(defaultEndDate);
    document.querySelector("#date-range-picker").value = `${startDate} s/d ${endDate}`;

    // Handler tombol download
    $('#downloadExcel').on('click', function (e) {
        e.preventDefault();

        const url = `/data-barang-keluar/export?start=${startDate}&end=${endDate}`;
        window.open(url, '_blank');
    });


    initDataTable();
</script>
@endscript

<script>

    document.addEventListener('DOMContentLoaded', () => {
        $('#detailModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget); // Button yang diklik
            const nomor = button.data('nomor'); // Nomor pengeluaran barang
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
                        modalHeader.style.backgroundColor = '#ffe107';
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
                    if ($.fn.DataTable.isDataTable('#detaildataTableModal')) {
                        $('#detaildataTableModal').DataTable().clear().destroy();
                    }

                    let statusPengeluaran = data.status;
                    let kategoriPengeluaran = data.kategori_pengeluaran;
                    let nomorPolisi = data.no_polisi;
                    
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
                    $('#detaildataTableModal').DataTable({
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
                            pageLength: 5, // Menentukan jumlah default entries per page menjadi 5
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

    document.addEventListener('DOMContentLoaded', function () {
        $(".select-tools").selectize({
            create: true, 
            sortField: 'text'
        });

        const selectAllCheckbox = document.getElementById('selectAll');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const selectedCountElement = document.getElementById('selected-count');
        const bulkApproveBtn = document.getElementById('bulk-approve-btn');
        const bulkRejectBtn = document.getElementById('bulk-reject-btn');

        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            updateBulkActionButtons();
        });

        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectAllState();
                updateBulkActionButtons();
            });
        });

        // function updateSelectAllState() {
        //     const totalCheckboxes = itemCheckboxes.length;
        //     const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked').length;
            
        //     if (checkedCheckboxes === 0) {
        //         selectAllCheckbox.indeterminate = false;
        //         selectAllCheckbox.checked = false;
        //     } else if (checkedCheckboxes === totalCheckboxes) {
        //         selectAllCheckbox.indeterminate = false;
        //         selectAllCheckbox.checked = true;
        //     } else {
        //         selectAllCheckbox.indeterminate = true;
        //         selectAllCheckbox.checked = false;
        //     }
        // }

        // function updateBulkActionButtons() {
        //     const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked').length;
        //     selectedCountElement.textContent = checkedCheckboxes;
            
        //     const hasSelection = checkedCheckboxes > 0;
        //     bulkApproveBtn.disabled = !hasSelection;
        //     bulkRejectBtn.disabled = !hasSelection;
        // }

        bulkApproveBtn.addEventListener('click', function () {
            const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
                .map(cb => ({
                    id: cb.value,
                    status: cb.getAttribute('data-status')
                }));

            if (selectedItems.length === 0) {
                Swal.fire('Peringatan!', 'Pilih minimal satu item untuk disetujui.', 'warning');
                return;
            }

            // Kelompokkan berdasarkan level
            const level1Items = selectedItems.filter(item => item.status === 'Level 1');
            const level2Items = selectedItems.filter(item => item.status === 'Level 2');
            const level3Items = selectedItems.filter(item => item.status === 'Level 3');
            const level4Items = selectedItems.filter(item => item.status === 'Level 4');

            // Teks pesan berdasarkan jumlah item
            const message = selectedItems.length === 1
                ? `Apakah Anda yakin ingin menyetujui <strong>1</strong> pengajuan ini?`
                : `Apakah Anda yakin ingin menyetujui <strong>${selectedItems.length}</strong> pengajuan yang dipilih?`;

            Swal.fire({
                title: selectedItems.length === 1 ? 'Konfirmasi Persetujuan' : 'Konfirmasi Persetujuan Massal',
                html: message,
                icon: 'question',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: selectedItems.length === 1 ? 'Ya, Setujui' : 'Ya, Setujui Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    processBulkApproval(level1Items, level2Items, level3Items, level4Items);
                }
            });
        });

        bulkRejectBtn.addEventListener('click', function () {
            const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
                .map(cb => cb.value);

            if (selectedItems.length === 0) {
                Swal.fire('Peringatan!', 'Pilih minimal satu item untuk ditolak.', 'warning');
                return;
            }

            const isMassal = selectedItems.length > 1;

            Swal.fire({
                title: isMassal ? 'Tolak Pengajuan Massal' : 'Tolak Pengajuan',
                html: `
                    <p>Anda akan menolak <strong>${selectedItems.length}</strong> pengajuan${isMassal ? ' yang dipilih' : ''}.</p>
                    <select id="alasanDropdown" class="swal2-select" style="width: 85%; margin-bottom: 10px; border-radius: 8px;">
                        <option value="">-- Pilih alasan penolakan cepat --</option>
                        <option value="Data tidak lengkap">Data tidak lengkap</option>
                        <option value="Tidak sesuai kebutuhan">Tidak sesuai kebutuhan</option>
                        <option value="Pengajuan tidak valid">Pengajuan tidak valid</option>
                    </select>
                    <textarea id="alasanPenolakan" class="swal2-textarea"
                        placeholder="Tuliskan alasan penolakan di sini..."
                        style="width: 85%; box-sizing: border-box; resize: vertical;"></textarea>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: isMassal ? 'Tolak Semua' : 'Tolak Pengajuan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                didOpen: () => {
                    const select = document.getElementById('alasanDropdown');
                    const textarea = document.getElementById('alasanPenolakan');

                    select.addEventListener('change', () => {
                        textarea.value = select.value;
                    });
                },
                preConfirm: () => {
                    const alasanSelect = document.getElementById('alasanDropdown').value.trim();
                    const alasanText = document.getElementById('alasanPenolakan').value.trim();
                    const alasan = alasanText || alasanSelect;

                    if (!alasan) {
                        Swal.showValidationMessage('Silakan pilih atau tulis alasan penolakan!');
                    }
                    return alasan;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    processBulkRejection(selectedItems, result.value);
                }
            });
        });


        function processBulkApproval(level1Items, level2Items, level3Items, level4Items) {
            const totalItems = level1Items.length + level2Items.length + level3Items.length + level4Items.length;
            const isMassal = totalItems > 1;

             Swal.fire({
                title: 'Memproses Persetujuan...',
                html: isMassal 
                    ? 'Mohon tunggu, sedang memproses persetujuan massal.' 
                    : 'Mohon tunggu, sedang memproses persetujuan.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const promises = [];

            // Process Level 1 approvals
            level1Items.forEach(item => {
                promises.push(
                    fetch("{{ route('approval.updateStatusKaSie') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            pengeluaran_barang_id : item.id
                        })
                    }).then(response => response.json())
                );
            });

            // Process Level 2 approvals
            level2Items.forEach(item => {
                // Check if the item is from GA department
                const itemElement = document.querySelector(`input[value="${item.id}"]`);
                const isDeptGA = itemElement.getAttribute('data-dept') === 'GENERAL AFFAIRS';
                
                if (isDeptGA) {
                    // For GA department items, use KaDeptGA route (will handle Level 2 -> Level 4)
                    promises.push(
                        fetch("{{ route('approval.updateStatusKaDeptGA') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                pengeluaran_barang_id : item.id
                            })
                        }).then(response => response.json())
                    );
                } else {
                    // For non-GA department items, use regular route
                    promises.push(
                        fetch("{{ route('approval.updateStatusKaDeptYBS') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                pengeluaran_barang_id : item.id
                            })
                        }).then(response => response.json())
                    );
                }
            });

            level3Items.forEach(item => {
                promises.push(
                    fetch("{{ route('approval.updateStatusKaDeptGA') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            pengeluaran_barang_id : item.id
                        })
                    }).then(response => response.json())
                );
            });

            level4Items.forEach(item => {
                promises.push(
                    fetch("{{ route('approval.updateStatusFinance') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            pengeluaran_barang_id : item.id
                        })
                    }).then(response => response.json())
                );
            });

            Promise.all(promises)
                .then(results => {
                    const successCount = results.filter(result => result.success).length;
                    const failCount = results.length - successCount;

                    if (failCount === 0) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: `Semua ${successCount} pengajuan berhasil disetujui.`,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Sebagian Berhasil',
                            html: `<strong>${successCount}</strong> pengajuan berhasil disetujui.<br><strong>${failCount}</strong> pengajuan gagal diproses.`,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
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

        function processBulkRejection(selectedItems, alasan) {
            const isMassal = selectedItems.length > 1;

            Swal.fire({
                title: 'Memproses Penolakan...',
                html: isMassal
                    ? 'Mohon tunggu, sedang memproses penolakan massal.'
                    : 'Mohon tunggu, sedang memproses penolakan.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const promises = selectedItems.map(itemId => {
                return fetch("{{ route('approval.rejectStatus') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        pengeluaran_barang_id: itemId,
                        alasan: alasan
                    })
                }).then(response => response.json());
            });

            Promise.all(promises)
                .then(results => {
                    const successCount = results.filter(result => result.success).length;
                    const failCount = results.length - successCount;

                    if (failCount === 0) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: isMassal
                                ? `Semua ${successCount} pengajuan berhasil ditolak.`
                                : 'Pengajuan berhasil ditolak.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Sebagian Berhasil',
                            html: `
                                ${isMassal
                                    ? `<strong>${successCount}</strong> pengajuan berhasil ditolak.<br><strong>${failCount}</strong> pengajuan gagal diproses.`
                                    : `Pengajuan gagal diproses.`}
                            `,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
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


        updateBulkActionButtons();

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