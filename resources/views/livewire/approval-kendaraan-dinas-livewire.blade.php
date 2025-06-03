<div class ="content-wrapper">
    <style>
         #dataTable {
        opacity: 0;
        transition: opacity 0.3s ease;
        }
        #dataTable.visible {
        opacity: 1;
        }

        #dataTable thead th:first-child {
            text-align: center !important;
            vertical-align: middle !important;
            padding: 8px 0 !important; /* Sesuaikan padding jika perlu */
        }

        #dataTable thead th:first-child input[type="checkbox"] {
            margin: 0 auto !important; /* Memusatkan checkbox secara horizontal */
            display: block !important;
            vertical-align: middle !important;
        }

        #dataTable tbody td:first-child {
            text-align: center !important;
            vertical-align: middle !important;
            padding: 8px 0 !important; /* Sesuaikan padding agar sesuai dengan header */
        }

        #dataTable tbody td:first-child input[type="checkbox"] {
            margin: 0 auto !important; /* Memusatkan checkbox di body */
            display: block !important;
            vertical-align: middle !important;
        }


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
        
        .tujuan-container-minimal {
            /* border-left: 4px solid #007bff; */
            /* background: #f8f9fa; */
            padding: 10px 15px;
            border-radius: 0 8px 8px 0;
            transition: all 0.3s ease;
        }

        .tujuan-container-minimal:hover {
            background: #e9ecef;
            border-left-color: #0056b3;
        }

        .tujuan-list-minimal {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 0;
        }

        .tujuan-item-minimal {
            background: #007bff;
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .tujuan-item-minimal:hover {
            background: #0056b3;
            transform: translateY(-1px);
        }

        .tujuan-number-minimal {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
    <div class="container-fluid">

        <div class="card mt-3">
           <div class="card-header" style="border-top: 5px solid #5A6ACF; display: flex; align-items: center; padding: 0.75rem 1.25rem;">
                <h6 class="m-0 font-weight-bold text-primary" style="flex-grow: 1;">Data Persetujuan</h6>
                <input type="text" id="date-range-picker" class="form-control" placeholder="Pilih Rentang Tanggal" style="max-width: 220px;">

                @if((Auth::check() && Auth::user()->level === 'Ka.Dept' && Auth::user()->departemen === 'GENERAL AFFAIRS') ||
                    (Auth::check() && Auth::user()->level === 'Ka.Sie' && Auth::user()->seksi === 'GENERAL SERVICES'))
                    
                    <a href="#" id="downloadExcel"
                    class="btn btn-success btn-sm d-flex align-items-center px-3"
                    style="height: 38px; white-space: nowrap;">
                    <i class="fas fa-file-excel fa-lg mr-2"></i>
                    <span>Export Excel</span>
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
                            <th>
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>NO</th>
                            <th>No Surat Pengajuan Kendaraan Dinas</th>
                            <th>Tujuan</th>
                            <th>Jenis Mobil</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach ($kendaraanDinas as $dataKD)
                            <tr>
                                <td>
                                    @php
                                        $canApprove = false;
                                        // Check if current user can approve this item
                                        
                                        // Ka.Dept dapat approve Level 1 dari departemen mereka sendiri
                                        if ($dataKD->status === 'Level 1' && $user->level === 'Ka.Dept') {
                                            // Untuk GENERAL AFFAIRS, Ka.Dept hanya approve dari dept GENERAL AFFAIRS
                                            if ($user->departemen === 'GENERAL AFFAIRS') {
                                                $canApprove = ($dataKD->user->departemen === 'GENERAL AFFAIRS');
                                            } 
                                            // Untuk departemen lain, Ka.Dept approve dari dept mereka kecuali GENERAL AFFAIRS
                                            else {
                                                $canApprove = ($dataKD->user->departemen === $user->departemen);
                                            }
                                        }
                                        
                                        // Ka.Sie GENERAL SERVICES dapat approve Level 2 dari semua departemen
                                        elseif ($dataKD->status === 'Level 2' && $user->level === 'Ka.Sie' && $user->seksi === 'GENERAL SERVICES') {
                                            $canApprove = true;
                                        }
                                        
                                        // Security dapat approve Level 3
                                        elseif ($dataKD->status === 'Level 3' && $user->level === 'Security') {
                                            $canApprove = true;
                                        }
                                    @endphp
                                    
                                    @if($canApprove)
                                        <input type="checkbox" 
                                            class="form-check-input item-checkbox" 
                                            value="{{ $dataKD->surat_kendaraan_dinas_id }}"
                                            data-status="{{ $dataKD->status }}">
                                    @endif
                                </td>
                                </td>
                                <td>{{ ++$i }}</td>
                                <td>{{ $dataKD->surat_kendaraan_dinas_id }}</td>
                                <td>
                                    @php
                                        $tujuanList = array_filter([
                                            $dataKD->tujuan_penggunaan_1,
                                            $dataKD->tujuan_penggunaan_2,
                                            $dataKD->tujuan_penggunaan_3
                                        ]);
                                    @endphp
                                    
                                    @if(count($tujuanList) > 0)
                                        <div class="tujuan-container-minimal">
                                            <div class="tujuan-list-minimal">
                                                @foreach($tujuanList as $index => $tujuan)
                                                    <span class="tujuan-item-minimal">
                                                        <span class="tujuan-number-minimal">{{ $index + 1 }}</span>
                                                        {{ $tujuan }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="no-tujuan">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>Tidak ada tujuan</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($dataKD->jenis_kendaraan == 1)
                                        Mobil kantor
                                    @elseif ($dataKD->jenis_kendaraan == 2)
                                        Mobil Pribadi
                                    @elseif ($dataKD->jenis_kendaraan == 3)
                                        Mobil Taxi
                                    @endif
                                </td>
                                <td>
                                    @if ($dataKD->status == 'Level 1')
                                        Menunggu Persetujuan Ka.Dept
                                    @elseif ($dataKD->status == 'Level 2')
                                        Menunggu Persetujuan Ka.Sie Transportasi
                                    @elseif ($dataKD->status == 'Level 3')
                                        Menunggu Persetujuan Security
                                    @elseif ($dataKD->status == 'Level 4')
                                        Sudah Disetujui
                                    @elseif ($dataKD->status == 'Level 0')
                                        Ditolak
                                    @else
                                        {{ $dataKD->status }}
                                    @endif
                                </td>
                                <td>
                                    <div class="button-group d-flex">
                                        <!-- Button Edit - Only for Ka.Sie with GA department and vehicle type 1 -->
                                        @if(($dataKD->status === 'Level 2' && $user->level === 'Ka.Sie' && $user->departemen == 'GENERAL AFFAIRS' && $dataKD->jenis_kendaraan == 1) ||
                                            (in_array($dataKD->status, ['Level 1', 'Level 2']) 
                                            && $user->level === 'Super Admin' 
                                            && $user->departemen === 'GENERAL AFFAIRS'))
                                            <button 
                                                type="button" 
                                                class="btn btn-warning btn-sm mr-2" 
                                                data-toggle="modal" 
                                                data-target="#editDataModal" 
                                                data-id="{{ $dataKD->surat_kendaraan_dinas_id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                        
                                        <!-- Button Detail -->
                                        <button 
                                            type="button" 
                                            class="btn btn-primary btn-sm mr-2" 
                                            data-toggle="modal" 
                                            data-target="#detailModal" 
                                            data-nomor="{{ $dataKD->surat_kendaraan_dinas_id }}">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Card Footer with Bulk Action Buttons -->
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
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Surat Dinas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <p><strong>Nomor Surat:</strong> <span id="nomorSuratCard"></span></p>
                    </div>
                    <!-- Card untuk Tabel Informasi Kendaraan -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">Informasi Kendaraan</h6>
                        </div>
                        <div class="card-body">
                            <table id="kendaraanInfoTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Kendaraan</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Penggunaan</th>
                                        <th>Tujuan 1</th>
                                        <th>Tujuan 2</th>
                                        <th>Tujuan 3</th>
                                    </tr>
                                </thead>
                                <tbody id="kendaraanInfoBody">
                                    <!-- Data akan diisi secara dinamis -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Card untuk Tabel Barang Keluar -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Informasi Peserta</h6>
                        </div>
                        <div class="card-body">
                            <table id="detaildataTableModal" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nrp Peserta</th>
                                        <th>Nama Peserta</th>
                                        <th>Departemen</th>
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

    <!-- Modal Edit Order Kendaraan Dinas -->
    <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Edit Order Kendaraan Dinas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Informasi Nomor Surat -->
                    <div class="d-flex justify-content-between align-items-center">
                        <p><strong>Nomor Surat:</strong> <span id="nomorSurat"></span></p>
                    </div>

                    <!-- Yang Memesan -->
                    <div class="col-md-12">
                        <label for="pemesan">Yang Memesan *</label>
                        <input type="hidden" id="surat_kendaraan_dinas_id">
                        <input type="text" id="pemesan" class="form-control" disabled>
                    </div>

                    <!-- Kendaraan Info -->
                    <label for="kendaraan" class="mt-2">Kendaraan *</label>
                    <div class="border p-2 table-responsive">
                        <table id="kendaraanInfo" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Kendaraan</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Penggunaan</th>
                                    <th>Tujuan 1</th>
                                    <th>Tujuan 2</th>
                                    <th>Tujuan 3</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabel Peserta -->
                    <label class="mt-3">Peserta *</label>
                    <table id="pesertaList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NRP</th>
                                <th>Nama Karyawan</th>
                                <th>Divisi Departemen</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <!-- Tombol Pindahkan Peserta -->
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-success" id="pindahkanPeserta">Pindahkan Peserta</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Pindah Peserta -->
    <div class="modal fade" id="modalPindahPeserta" tabindex="-1" aria-labelledby="staticBackdropModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pindah Ke Surat Persetujuan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="nrpPesertaDipindah" />
                    <input type="hidden" id="tanggalPakai" class="form-control" disabled>
                    <!-- Tabel Peserta yang Dipindahkan -->
                    <h6><strong>Karyawan Yang Dipindahkan</strong></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabelPesertaDipindah">
                            <thead>
                                <tr>
                                    <th>NRP</th>
                                    <th>Nama Karyawan</th>
                                    <th>Nama Departemen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data via jQuery -->
                            </tbody>
                        </table>
                    </div>
                
                    <!-- Tabel Tujuan Dipindahkan -->
                    <h6 class="mt-4"><strong>Tujuan dipindahkan</strong></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabelTujuanSurat">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Surat</th>
                                    <th>Tujuan</th>
                                    <th>Jenis Mobil</th>
                                    <th>No Kendaraan</th>
                                    <th>Status</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data via jQuery -->
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnSimpanPindah">Pindah</button>
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
                orderable: false // Opsional: Matikan sorting untuk kolom checkbox
            },
                { className: 'dt-body-center', targets: 6 },
                { className: 'dt-head-center', targets: 6 }
            ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            scrollX: false,
            responsive: true,
            initComplete: function() {
                // tampilkan setelah selesai inisialisasi
                table.addClass('visible');
            }
        });
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

        const url = `/data-kendaraan-dinas/export?start=${startDate}&end=${endDate}`;
        window.open(url, '_blank');
    });


    initDataTable();
</script>
@endscript


<script>
    const currentUserRole = "{{ Auth::user()->level }}";
    let pesertaDipindahkan = [];

    $('#pindahkanPeserta').click(function () {
        pesertaDipindahkan = [];
        $('#pesertaList input[type="checkbox"]:checked').each(function () {
            pesertaDipindahkan.push($(this).val());
        });

        if (pesertaDipindahkan.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak ada peserta dipilih',
                text: 'Silakan pilih peserta yang ingin dipindahkan.',
            });
            return;
        }

        const tanggal = $('#tanggalPakai').val();
        const currentSuratId = $('#surat_kendaraan_dinas_id').val();

        $.ajax({
            url: "/pengajuan/surat-tujuan",
            type: "GET",
            data: {
                tanggal_penggunaan: tanggal,
                current_surat_id: currentSuratId
            },
            success: function (data) {
                const pesertaList = [];
                $('#pesertaList input[type="checkbox"]:checked').each(function () {
                    const row = $(this).closest('tr');
                    const nrp = row.find('td:eq(1)').text();
                    const nama = row.find('td:eq(2)').text();
                    const dept = row.find('td:eq(3)').text();
                    pesertaList.push({ nrp, nama, dept });
                });

                const tbodyPeserta = $("#tabelPesertaDipindah tbody");
                tbodyPeserta.empty();
                pesertaList.forEach(p => {
                    tbodyPeserta.append(`
                        <tr>
                            <td>${p.nrp}</td>
                            <td>${p.nama}</td>
                            <td>${p.dept}</td>
                        </tr>
                    `);
                });

                let tbody = $("#tabelTujuanSurat tbody");
                tbody.empty();

                data.forEach((item, index) => {
                    tbody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.surat_kendaraan_dinas_id}</td>
                            <td>${item.tujuan_penggunaan_1}</td>
                            <td>${item.jenis_kendaraan}</td>
                            <td>${item.nomor_kendaraan || '-'}</td>
                            <td>${item.status}</td>
                            <td>
                                <input type="radio" name="surat_tujuan" value="${item.surat_kendaraan_dinas_id}">
                            </td>
                        </tr>
                    `);
                });

                $('#modalPindahPeserta').modal('show');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const exportBtn = document.getElementById('exportExcel');
        const savedRange = localStorage.getItem("selectedDateRange");

        // Atur URL export jika sudah ada range
        if (savedRange) {
            const { start, end } = JSON.parse(savedRange);
            exportBtn.href = `/data-kendaraan-dinas/export?start=${start}&end=${end}`;
        }

        // Inisialisasi Flatpickr
        flatpickr("#date-range-picker", {
            mode: "range",
            dateFormat: "Y-m-d",
            locale: "id",
            defaultDate: savedRange ? [JSON.parse(savedRange).start, JSON.parse(savedRange).end] : null,
            onChange: function (selectedDates) {
                if (selectedDates.length === 2) {
                    const start = selectedDates[0].toISOString().split('T')[0];
                    const end = selectedDates[1].toISOString().split('T')[0];

                    // Update href tombol export
                    exportBtn.href = `/data-kendaraan-dinas/export?start=${start}&end=${end}`;
                }
            }
        });
    });

    // SIMPAN PINDAH
    $('#btnSimpanPindah').click(function () {
        const suratTujuan = $('input[name="surat_tujuan"]:checked').val();
        if (!suratTujuan) {
            Swal.fire({
                icon: 'warning',
                title: 'Surat tujuan belum dipilih',
                text: 'Silakan pilih salah satu surat tujuan terlebih dahulu.',
            });
            return;
        }

        $.ajax({
            url: '/pengajuan/pindahkan-peserta',
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                peserta: pesertaDipindahkan,
                surat_tujuan: suratTujuan
            },
            success: function () {
                let pesan = pesertaDipindahkan.map(nrp => `• Peserta dengan NRP ${nrp} berhasil dipindahkan ke surat dinas ${suratTujuan}.`).join('<br>');

                Swal.fire({
                    icon: 'success',
                    title: 'Pemindahan Berhasil',
                    html: pesan,
                    confirmButtonText: 'Tutup'
                }).then(() => {
                    location.reload();
                });
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat memindahkan peserta. Silakan coba lagi.',
                });
            }
        });
    });

    $('#editDataModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); 
        const dataKD = button.data('id'); 

        $('#nomorSurat').text('');
        $('#pemesan').val('');
        $('#kendaraanInfo tbody').empty();
        $('#pesertaList tbody').empty();

        $.ajax({
            url: "/pengajuan/edit", // Sesuaikan dengan route Laravel
            type: "POST",
            data: { 
                surat_kendaraan_dinas_id: dataKD,
                "_token": "{{ csrf_token() }}"  // CSRF token
            },
            dataType: "json",
            success: function (response) {
                if (!response || !response.surat_kendaraan_dinas_id) {
                    alert("Data tidak valid.");
                    return;
                }

                const isSuperAdmin = currentUserRole === "Super Admin";

                // Simpan daftar kendaraan ke global
                window.daftarKendaraanGlobal = response.daftar_kendaraan || [];

                // Isi field form utama
                $("#surat_kendaraan_dinas_id").val(response.surat_kendaraan_dinas_id);
                $("#pemesan").val(response.userDinas?.[0]?.nrp_karyawan || '');
                $("#nomorSurat").text(response.surat_kendaraan_dinas_id || '');
                $("#tanggalPakai").val(response.tanggal_penggunaan || '');

                // Render Kendaraan
                renderDaftarKendaraan(response);

                // Render Peserta
                renderDaftarPeserta(response.userDinas || []);
            },
            error: function () {
                alert("Gagal mengambil data. Coba lagi.");
            },
        });
    });

    function renderDaftarKendaraan(response) {
        const tbody = $("#kendaraanInfo tbody");
        tbody.empty();

        const dataKendaraan = response.data_kendaraan || [];
        dataKendaraan.forEach((item, index) => {
            const jenisKendaraan = response.jenis_kendaraan || '';
            const tanggalPenggunaan = response.tanggal_penggunaan || '';
            const tujuan1 = response.tujuan_penggunaan_1 || '';
            const tujuan2 = response.tujuan_penggunaan_2 || '';
            const tujuan3 = response.tujuan_penggunaan_3 || '';

            tbody.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td class="nomor-kendaraan">${item.nomor_kendaraan || ''}</td>
                    <td class="keterangan-kendaraan">${item.keterangan || ''}</td>
                    <td>${tanggalPenggunaan}</td>
                    <td>${tujuan1}</td>
                    <td>${tujuan2}</td>
                    <td>${tujuan3}</td>
                </tr>
            `);
        });
    }

    function renderDaftarPeserta(dataPeserta) {
        const tbody = $("#pesertaList tbody");
        tbody.empty();

        dataPeserta.forEach((user, index) => {
            tbody.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${user.nrp_karyawan}</td>
                    <td>${user.name}</td>
                    <td>${user.departemen}</td>
                    <td><input type="checkbox" name="peserta[]" value="${user.nrp_karyawan}"></td>
                </tr>
            `);
        });
    }

    function updateKeterangan(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const keterangan = selectedOption.getAttribute("data-ket") || '';
        
        const row = $(selectElement).closest("tr");
        row.find(".keterangan-kendaraan").text(keterangan);
    }

    document.addEventListener('DOMContentLoaded', () => {
        $('#detailModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget); // Button yang diklik
            const nomor = button.data('nomor'); // Nomor pengeluaran barang
            document.getElementById('nomorSuratCard').innerText = nomor;

            $.ajax({
                url: "/pengajuan/detailSurat",
                method: "POST",
                data: { surat_kendaraan_dinas_id: nomor, "_token": "{{ csrf_token() }}" },
                success: function (data) {
                    const detailTable = $('#detaildataTableModal').DataTable();

                    const jenisKendraan = {
                        1 : "Mengeluarkan"
                    };

                    // Kosongkan data lama kendaraan
                    document.getElementById('kendaraanInfoBody').innerHTML = "";

                    // Validasi dan tampilkan data kendaraan
                    if (data.data_kendaraan && data.data_kendaraan.length > 0) {
                        data.data_kendaraan.forEach((item, index) => {
                            let row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.nomor_kendaraan}</td>
                                    <td>${item.keterangan}</td>
                                    <td>${item.tanggal_penggunaan || '-'}</td>
                                    <td>${item.tujuan_penggunaan_1 || '-'}</td>
                                    <td>${item.tujuan_penggunaan_2 || '-'}</td>
                                    <td>${item.tujuan_penggunaan_3 || '-'}</td>
                                </tr>
                            `;
                            document.getElementById('kendaraanInfoBody').innerHTML += row;
                        });
                    } else {
                        document.getElementById('kendaraanInfoBody').innerHTML = `
                            <tr><td colspan="4" class="text-center">Tidak ada data kendaraan</td></tr>
                        `;
                    }

                    // Kosongkan data laa
                    detailTable.clear();
                    document.getElementById('additionalInfoBody').innerHTML = ""; // Kosongkan tabel Informasi Tambahan

                   
                    if (data.userDinas && data.userDinas.length > 0) {
                        let newData = data.userDinas.map((item, index) => [
                            index + 1,
                            item.nrp_karyawan,
                            item.name,
                            item.departemen
                        ]);
                        detailTable.rows.add(newData).draw();
                    } else {
                        detailTable.rows.add([["", "", "Tidak ada data user", "", "", ""]]).draw();
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
                        "Level 3": "Mengetahui",
                        "Level 4": "Memeriksa"
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
        // Inisialisasi Selectize
        $('.select-tools').selectize({
            create: true,
            sortField: 'text'
        });

        // Variables for bulk operations
        const selectAllCheckbox = document.getElementById('selectAll');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const selectedCountElement = document.getElementById('selected-count');
        const bulkApproveBtn = document.getElementById('bulk-approve-btn');
        const bulkRejectBtn = document.getElementById('bulk-reject-btn');

        // Handle Select All functionality
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            updateBulkActionButtons();
        });

        // Handle individual checkbox changes
        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectAllState();
                updateBulkActionButtons();
            });
        });

        // Update Select All state based on individual checkboxes
        function updateSelectAllState() {
            const totalCheckboxes = itemCheckboxes.length;
            const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked').length;
            
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
            selectedCountElement.textContent = checkedCheckboxes;
            
            const hasSelection = checkedCheckboxes > 0;
            bulkApproveBtn.disabled = !hasSelection;
            bulkRejectBtn.disabled = !hasSelection;
        }

        // Bulk Approve Handler
        bulkApproveBtn.addEventListener('click', function() {
            const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
                .map(cb => ({
                    id: cb.value,
                    status: cb.getAttribute('data-status')
                }));

            if (selectedItems.length === 0) {
                Swal.fire('Peringatan!', 'Pilih minimal satu item untuk disetujui.', 'warning');
                return;
            }

            // Group by status for different approval levels
            const level1Items = selectedItems.filter(item => item.status === 'Level 1');
            const level2Items = selectedItems.filter(item => item.status === 'Level 2');

            Swal.fire({
                title: 'Konfirmasi Persetujuan Massal',
                html: `Apakah Anda yakin ingin menyetujui <strong>${selectedItems.length}</strong> pengajuan yang dipilih?`,
                icon: 'question',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Setujui Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    processBulkApproval(level1Items, level2Items);
                }
            });
        });

        // Bulk Reject Handler
        bulkRejectBtn.addEventListener('click', function() {
            const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
                .map(cb => cb.value);

            if (selectedItems.length === 0) {
                Swal.fire('Peringatan!', 'Pilih minimal satu item untuk ditolak.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Tolak Pengajuan Massal',
                html: `
                    <p>Anda akan menolak <strong>${selectedItems.length}</strong> pengajuan yang dipilih.</p>
                    <select id="alasanDropdown" class="swal2-select" style="width: 85%; margin-bottom: 10px;">
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
                confirmButtonText: 'Tolak Semua',
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

        // Process bulk approval
        function processBulkApproval(level1Items, level2Items) {
            Swal.fire({
                title: 'Memproses Persetujuan...',
                html: 'Mohon tunggu, sedang memproses persetujuan massal.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const promises = [];

            // Process Level 1 approvals
            level1Items.forEach(item => {
                promises.push(
                    fetch("{{ route('pengajuanDinas.updateStatusKaDeptYBS') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            surat_kendaraan_dinas_id: item.id
                        })
                    }).then(response => response.json())
                );
            });

            // Process Level 2 approvals
            level2Items.forEach(item => {
                promises.push(
                    fetch("{{ route('pengajuanDinas.updateStatusKaSieTransport') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            surat_kendaraan_dinas_id: item.id
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

        // Process bulk rejection
        function processBulkRejection(selectedItems, alasan) {
            Swal.fire({
                title: 'Memproses Penolakan...',
                html: 'Mohon tunggu, sedang memproses penolakan massal.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const promises = selectedItems.map(itemId => {
                return fetch("{{ route('pengajuanDinas.rejectStatus') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        surat_kendaraan_dinas_id: itemId,
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
                            text: `Semua ${successCount} pengajuan berhasil ditolak.`,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Sebagian Berhasil',
                            html: `<strong>${successCount}</strong> pengajuan berhasil ditolak.<br><strong>${failCount}</strong> pengajuan gagal diproses.`,
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

        // Initialize state
        updateBulkActionButtons();
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