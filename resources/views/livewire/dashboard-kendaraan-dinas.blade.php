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

    .btn-outline-primary.custom-color {
        color: #5A6ACF !important;
        border-color: #5A6ACF !important;
        }

        .btn-outline-primary.custom-color:hover,
        .btn-outline-primary.custom-color:focus,
        .btn-outline-primary.custom-color:active,
        .btn-outline-primary.custom-color.active {
        background-color: #5A6ACF !important;
        color: white !important;
        border-color: #5A6ACF !important;
        }

        .badge {
            margin-right: 4px;
            font-size: 90%;
        }
        .badge.bg-pink {
            background-color: #e83e8c;
            color: white;
        }
        .badge.bg-purple {
            background-color: #6f42c1;
            color: white;
        }
        .badge.bg-orange {
            background-color: #fd7e14;
            color: white;
        }
        .badge.bg-brown {
            background-color: #795548;
            color: white;
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

        /* FIXED: Ensure all body cells are vertically centered */
        #dataTable td {
            vertical-align: middle !important;
            line-height: 1 !important;
            display: table-cell !important;
        }

</style>
    <div class="container-fluid">
        <body>
            <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center" style="border-top: 5px solid #5A6ACF;">

            <div class="row g-2 align-items-center w-100">
                @if ($user->level === 'Ka.Dept' || $user->level === 'Super Admin' || $user->level === 'Security' || $user->seksi==='GENERAL SERVICES')
                    <!-- Tombol Switch -->
                    <div class="col-md-8 col-12">
                        <div class="d-flex flex-wrap border rounded overflow-hidden w-100">
                            <a href="{{ route('dashboard-barang-keluar') }}"
                            class="d-flex align-items-center justify-content-center px-3 py-2 {{ request()->is('dashboard-barang-keluar') ? 'text-white' : 'text-dark bg-white' }}"
                            style="background-color: {{ request()->is('dashboard-barang-keluar') ? '#5A6ACF' : 'white' }};
                                    text-decoration: none; flex: 1; white-space: normal; text-align: center; font-weight: 400;">
                                Barang Keluar
                            </a>
                            <a href="{{ route('dashboard-kendaraan-dinas') }}"
                            id="switch-kendaraan-dinas"
                            class="d-flex align-items-center justify-content-center px-3 py-2 {{ request()->is('dashboard-kendaraan-dinas') ? 'text-white' : 'text-dark bg-white' }}"
                            style="background-color: {{ request()->is('dashboard-kendaraan-dinas') ? '#5A6ACF' : 'white' }};
                                    text-decoration: none; border-left: 1px solid #ccc; flex: 1; white-space: normal; text-align: center; font-weight: 400;">
                                Penggunaan Kendaraan Dinas
                            </a>
                        </div>
                    </div>
                @else
                    <div class="col-md-8 col-12">
                        <h5 class="m-0 font-weight-bold text-primary">Informasi Pengajuan Akumulasi Harian</h5>
                    </div>
                @endif

                <!-- Input Tanggal, ditampilkan untuk semua user -->
                <div class="col-md-4 col-12">
                    <div class="input-group">
                        <input type="text" id="date-range-picker" class="form-control" placeholder="Pilih rentang tanggal penggunaan">
                    </div>
                </div>
            </div>


            </div>             
                <div class="card-body">
                    <div class="row">
                        <!-- Card Jumlah Pengajuan -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 class="jumlah-pengajuan">{{ $suratKendaraanDinas->count() ?? 0 }}</h3>
                                    <p>Jumlah Pengajuan</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-alt"></i> <!-- Ikon dokumen -->
                                </div>
                                <!-- Card Jumlah Pengajuan -->
                                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modalPengajuan" data-status="all">Lebih Banyak <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <!-- Card Jumlah Disetujui -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3  class="jumlah-disetujui">{{ $kendaraanDisetujui ?? 0 }}</h3>
                                    <p>Jumlah Disetujui</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i> <!-- Ikon centang -->
                                </div>
                                <!-- Card Jumlah Disetujui -->
                                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modalPengajuan" data-status="approved">Lebih Banyak <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <!-- Card Jumlah Menunggu -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3  class="jumlah-menunggu">{{ $kendaraanMenunggu ?? 0 }}</h3>
                                    <p>Jumlah Menunggu</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i> <!-- Ikon jam -->
                                </div>
                                <!-- Card Jumlah Menunggu -->
                                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modalPengajuan" data-status="pending">Lebih Banyak <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <!-- Card Jumlah Ditolak -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3 class="jumlah-ditolak">{{ $kendaraanDitolak ?? 0 }}</h3>
                                    <p>Jumlah Ditolak</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-times-circle"></i> <!-- Ikon silang -->
                                </div>
                                <!-- Card Jumlah Ditolak -->
                                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modalPengajuan" data-status="rejected">Lebih Banyak <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                            <!-- Modal -->
                            <div class="modal fade" id="modalPengajuan" tabindex="-1" role="dialog" aria-labelledby="modalPengajuanLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="modalPengajuanLabel">Detail Jumlah Pengajuan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Data Table -->
                                        <table id="dataTable" class="table table-striped table-bordered nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>Nomor Surat Kendaraan Dinas</th>
                                                    <th>Rute</th>
                                                    <th>Jenis Kendaraan</th>
                                                    <th>Status</th>
                                                    <th>Detail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($suratKendaraanDinas as $a)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $a->surat_kendaraan_dinas_id }}</td>
                                                    <td>
                                                        @php
                                                            $tujuanList = array_filter([
                                                                $a->tujuan_penggunaan_1,
                                                                $a->tujuan_penggunaan_2,
                                                                $a->tujuan_penggunaan_3
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
                                                        {{ $a->jenis_kendaraan }}
                                                    </td>
                                                    <td>
                                                        @switch($a->status)
                                                            @case('Level 1')
                                                                Menunggu Persetujuan PIC/Ka.Sie
                                                                @break
                                                            @case('Level 2')
                                                                PIC/Ka.Sie Sudah Menyetujui
                                                                @break
                                                            @case('Level 3')
                                                                Menunggu Persetujuan Ka.Dept GA
                                                                @break
                                                            @case('Level 4')
                                                               Menunggu Persetujuan Security
                                                                @break
                                                            @case('Level 5')
                                                                Sudah Disetujui
                                                            @break
                                                            @case('Level 0')
                                                                Ditolak
                                                                @break
                                                            @default
                                                                {{ $a->status }}
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        <button 
                                                            type="button" 
                                                            class="btn btn-primary btn-sm" 
                                                            data-toggle="modal" 
                                                            data-target="#detailModalPenggunaan" 
                                                            data-nomor="{{ $a->surat_kendaraan_dinas_id }}">
                                                            <i class="fa-solid fa-circle-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Detail Modal Penggunaan Kendaraan --}}
                        <div class="modal fade" id="detailModalPenggunaan" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <h5 class="modal-title" id="detailModalLabel">Detail Surat Dinas</h5>
                                            <!-- Badge Status di Header -->
                                            <div id="approvalStatusBadgeDinas"></div>
                                        </div>
                                        <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">


                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <p><strong>Nomor Surat:</strong> <span id="nomorSuratCard"></span></p>    
                                        </div>
                        
                                        <!-- Card untuk Tabel Informasi Kendaraan -->
                                        <div class="card mb-4">
                                            <div class="card-header bg-primary text-white">
                                                <h6 class="mb-0">Informasi Kendaraan</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                <table id="kendaraanInfoTable" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center">No</th>
                                                            <th>No Kendaraan</th>
                                                            <th>Keterangan</th>
                                                            <th>Tanggal Penggunaan</th>
                                                            <th>Rute 1</th>
                                                            <th>Rute 2</th>
                                                            <th>Rute 3</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="kendaraanInfoBody">
                                                        <!-- Data akan diisi secara dinamis -->
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <!-- Card untuk Peserta Kendaraan Dinas -->
                                        <div class="card">
                                            <div class="card-header bg-primary text-white">
                                                <h6 class="mb-0">Informasi Peserta</h6>
                                            </div>
                                            <div class="card-body">
                                                <table id="detaildataTableModal" class="table table-striped table-bordered">
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
                                            <div class="card-header bg-primary text-white">
                                                <h6 class="mb-0">Informasi Historis Persetujuan</h6>
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
                                                            <th>Alasan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="addhistory">
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
                    </div>
                    
                    <!-- Row kedua -->
                    <div class="row">
                        <!-- Kotak Kendaraan Dinas Tersedia -->
                        <div class="col-lg-6 col-12">
                            <div class="small-box" style="background-color: #20c997; color: white;"> <!-- Teal -->
                                <div class="inner">
                                    <h3 class="jumlah-kendaraan-tersedia">{{ $kendaraanDinasTersedia ?? 0 }}</h3>
                                    <p>Kendaraan Dinas Tersedia</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-car-side"></i>
                                </div>
                                <a href="#" class="small-box-footer text-white" data-status="ready" data-toggle="modal" data-target="#modalKendaraan">
                                    Lebih Banyak <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Kotak Kendaraan Dinas Digunakan -->
                        <div class="col-lg-6 col-12">
                            <div class="small-box" style="background-color: #117864; color: white;"> <!-- Purple -->
                                <div class="inner">
                                    <h3 class="jumlah-kendaraan-digunakan">{{ $kendaraanDinasSedangDigunakan ?? 0 }}</h3>
                                    <p>Kendaraan Dinas Digunakan</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-route"></i>
                                </div>
                                <a href="#" class="small-box-footer text-white" data-status="occupied" data-toggle="modal" data-target="#modalKendaraan">
                                    Lebih Banyak <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- Modal Kendaraan Tersedia dan Tidak Tersedia--}}
                    <div class="modal fade" id="modalKendaraan" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document"> <!-- Ganti dari modal-xl ke modal-lg -->
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">Data Kendaraan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <!-- Modal Kendaraan Tersedia -->
                                        <table id="dataTableKendaraan" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>Jenis Kendaraan</th>
                                                    <th>Nomor Kendaraan</th>
                                                    <th>Kapasitas Penumpang</th>
                                                    <th>Tanggal Penggunaan</th>
                                                    <th>Surat Kendaraan Dinas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data akan diisi secara dinamis -->
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Bagian Kiri - Diagram Batang dengan Filter -->
                    <div class="@if(Auth::check() && in_array(Auth::user()->level, ['Ka.Dept', 'Security','Super Admin'])) col-md-6 @else col-md-12 @endif">
                        <div class="card">
                            <div class="card-header" style="border-top: 5px solid #5A6ACF; padding-left: 10;">
                                <div class="btn-group" role="group" style="margin-left: 0;">
                                       <button type="button" class="btn btn-outline-primary custom-color active" data-filter="harian">Harian</button>
                                        <button type="button" class="btn btn-outline-primary custom-color" data-filter="bulanan">Bulanan</button>
                                        <button type="button" class="btn btn-outline-primary custom-color" data-filter="tahunan">Tahunan</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Bagian Kanan - Diagram Pie -->
                    @if(Auth::check() && in_array(Auth::user()->level, ['Ka.Dept', 'Security', 'Super Admin']))
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header" style="border-top: 5px solid  #5A6ACF;">
                             <h6 class="m-0 font-weight-bold" style="flex-grow: 1; color: #5A6ACF;" >Berdasarkan Kategori Kendaraan</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </body>

        <script>
            const dailyData = {!! $dailyData !!};
            const monthlyData = {!! $monthlyData !!};
            const yearlyData = {!! $yearlyData !!};
            const pieData = {!! $pieData !!};

            // Ambil elemen canvas untuk Bar Chart
            const ctxBar = document.getElementById('barChart').getContext('2d');

           // 🔹 Inisialisasi Bar Chart
            let barChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: dailyData.labels,
                    datasets: [{
                        label: 'Jumlah Surat Penggunaan Kendaraan Dinas',
                        data: dailyData.data,
                        backgroundColor: 'rgba(23, 162, 184, 0.6)', // bg-info dengan transparansi
                        borderColor: 'rgba(23, 162, 184, 1)',       // bg-info solid
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });

            // 🔹 Cek apakah elemen pieChart ada sebelum membuat Pie Chart
            const pieCanvas = document.getElementById('pieChart');

            if (pieCanvas) {
            try {
                const ctxPie = pieCanvas.getContext('2d');

                const labels = ['Kantor', 'Pribadi', 'Taxi'];
                const colors = ['#28a745', '#007bff', '#ffc107'];

                // Ambil nilai-nilai sesuai urutan label
                const dataValues = labels.map(label => pieData[label] ?? 0);

                // Cek jika semua data kosong (0)
                const isEmpty = dataValues.every(val => val === 0);

                // Plugin untuk menampilkan teks tengah jika data kosong
                const centerTextPlugin = {
                    id: 'centerText',
                    beforeDraw(chart) {
                        if (isEmpty) {
                            const { width, height } = chart;
                            const ctx = chart.ctx;
                            ctx.save();
                            ctx.font = 'bold 16px sans-serif';
                            ctx.fillStyle = '#6c757d'; // abu-abu netral
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle'; 
                            ctx.fillText('Belum Ada Data', width / 2, height / 2 + 20); 
                            ctx.restore();
                        }
                    }
                };

                // Inisialisasi Pie Chart
                const pieChart = new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jenis Penggunaan',
                            data: dataValues,
                            backgroundColor: colors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'right'
                            }
                        }
                    },
                    plugins: [centerTextPlugin]
                });

            } catch (error) {
                console.error("Pie Chart tidak dapat diinisialisasi:", error);
            }
        }

            // 🔹 Filter untuk Bar Chart (Harian, Bulanan, Tahunan)
            document.querySelectorAll('.btn-group .btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');
                    let selectedData;

                    if (filterValue === 'harian') {
                        selectedData = dailyData;
                    } else if (filterValue === 'bulanan') {
                        selectedData = monthlyData;
                    } else if (filterValue === 'tahunan') {
                        selectedData = yearlyData;
                    }

                    // 🔄 Update Chart Data
                    barChart.data.labels = selectedData.labels;
                    barChart.data.datasets[0].data = selectedData.data;

                    // 🔄 Update Chart
                    barChart.update();S
                });
            });

                document.addEventListener('DOMContentLoaded', () => {
                    var table = $('#dataTable').DataTable({
                        columnDefs: [
                                {className: 'dt-head-center', targets: 0},
                                {className: 'dt-head-center', targets: 5},

                                {className: 'dt-body-center', targets: 0},
                                {className: 'dt-body-center', targets: 5}
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
                        scrollX: false,
                        responsive: true
                    });

                    var table = $('#dataTableKendaraan').DataTable({
                        columnDefs: [
                            {className: 'dt-head-center', targets: 0},
                            {className: 'dt-head-left', targets: 3},
                            
                            {className: 'dt-body-center', targets: 0},
                            {className: 'dt-body-left', targets: 3}
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
                        scrollX: false,
                        responsive: true
                    });



                    $(document).ready(function () {
                        $('#detailModalPenggunaan').on('show.bs.modal', function (event) {
                            const button = $(event.relatedTarget); // Tombol yang diklik
                            const nomor = button.data('nomor'); 
                            document.getElementById('nomorSuratCard').innerText = nomor;

                            $.ajax({
                                url: "/pengajuan/detailSurat",
                                method: "POST",
                                data: { surat_kendaraan_dinas_id: nomor, "_token": "{{ csrf_token() }}" },
                                    success: function (data) {
                                    const detailTable = $('#detaildataTableModal').DataTable();

                                    const jenisKendraan = {
                                        1: "Mengeluarkan"
                                    };

                                    let statusBadgeHTML = '';
                                    const informasiTambahan = data.informasi_tambahan ?? [];

                                    // Cek apakah ada yang menolak
                                    const adaYangMenolak = informasiTambahan.some(x => x.status === 'Level 0');

                                    // Cek level tertinggi yang menyetujui
                                    const maxLevel = Math.max(...informasiTambahan.map(x => parseInt(x.status?.replace('Level ', '')) || 0));

                                    const tombolCetak = document.getElementById('cetakBukti');

                                    // Logika tampil/sembunyikan tombol
                                    if (tombolCetak) {
                                        if (adaYangMenolak || maxLevel < 3) {
                                            tombolCetak.style.display = "none";
                                        } else {
                                            tombolCetak.style.display = "inline-block";
                                        }
                                    }

                                    if (adaYangMenolak) {
                                        statusBadgeHTML = `
                                            <span style="display: inline-flex; align-items: center; justify-content: center; width: 110px; height: 40px; font-size: 0.85rem; padding: 0.25rem; border-radius: 0.5rem; background-color: #dc3545; color: white;">
                                                <i class="fas fa-times-circle" style="font-size: 1rem; margin-right: 4px;"></i> Ditolak
                                            </span>
                                        `;
                                    } else if (maxLevel >= 3) {
                                        statusBadgeHTML = `
                                            <span style="display: inline-flex; align-items: center; justify-content: center; width: 110px; height: 40px; font-size: 0.85rem; padding: 0.25rem; border-radius: 0.5rem; background-color: #28a745; color: white;">
                                                <i class="fas fa-clipboard-check" style="font-size: 1rem; margin-right: 4px;"></i> Lengkap
                                            </span>
                                        `;
                                    } else {
                                        statusBadgeHTML = `
                                            <span style="display: inline-flex; align-items: center; justify-content: center; width: 150px; height: 40px; font-size: 0.85rem; padding: 0.25rem; border-radius: 0.5rem; background-color: #ffc107; color: black;">
                                                <i class="fas fa-exclamation-circle" style="font-size: 1rem; margin-right: 6px;"></i> Belum Lengkap
                                            </span>
                                        `;
                                    }

                                    document.getElementById('approvalStatusBadgeDinas').innerHTML = statusBadgeHTML;

                                    // Kosongkan data lama kendaraan
                                    document.getElementById('kendaraanInfoBody').innerHTML = "";

                                    if ($.fn.DataTable.isDataTable('#detaildataTableModal')) {
                                        $('#detaildataTableModal').DataTable().clear().destroy();
                                    }

                                    // Simpan kilometer awal dan akhir untuk print
                                    let kilometerAwal = data.kilometer_awal || '-';
                                    let kilometerAkhir = data.kilometer_akhir || '-';
                                    let hasPrivateVehicle = data.has_private_vehicle || false;

                                    // Validasi dan tampilkan data kendaraan
                                    if (data.data_kendaraan && data.data_kendaraan.length > 0) {
                                        data.data_kendaraan.forEach((item, index) => {
                                            let row = `
                                                <tr>
                                                    <td style="text-align: center">${index + 1}</td>
                                                    <td>${item.nomor_kendaraan}</td>
                                                    <td>${item.keterangan}</td>
                                                    <td style="text-align: right">${item.tanggal_penggunaan || '-'}</td>
                                                    <td>${item.tujuan_penggunaan_1 || '-'}</td>
                                                    <td>${item.tujuan_penggunaan_2 || '-'}</td>
                                                    <td>${item.tujuan_penggunaan_3 || '-'}</td>
                                                </tr>
                                            `;
                                            document.getElementById('kendaraanInfoBody').innerHTML += row;
                                        });

                                        // Simpan kilometer data untuk print
                                        let kilometerElement = document.getElementById('kilometerData');
                                        if (!kilometerElement) {
                                            kilometerElement = document.createElement('div');
                                            kilometerElement.id = 'kilometerData';
                                            kilometerElement.style.display = 'none';
                                            document.body.appendChild(kilometerElement);
                                        }
                                        kilometerElement.setAttribute('data-kilometer-awal', kilometerAwal);
                                        kilometerElement.setAttribute('data-kilometer-akhir', kilometerAkhir);
                                        kilometerElement.setAttribute('data-has-private-vehicle', hasPrivateVehicle);
                                    } else {
                                        document.getElementById('kendaraanInfoBody').innerHTML = `
                                            <tr><td colspan="7" class="text-center">Tidak ada data kendaraan</td></tr>
                                        `;
                                    }

                                    // Kosongkan data lama
                                    detailTable.clear();
                                    document.getElementById('addhistory').innerHTML = "";

                                    // Validasi data userDinas
                                    if (data.userDinas && data.userDinas.length > 0) {
                                        let newData = data.userDinas.map((item, index) => [
                                            index + 1,
                                            item.nrp_karyawan,
                                            item.name,
                                            item.departemen
                                        ]);
                                        detailTable.rows.add(newData).draw();
                                    } else {
                                        detailTable.rows.add([["", "", "Tidak ada data user", ""]]).draw();
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
                                        "Level 4": "Menyetujui"
                                    };

                                    // Validasi data informasi_tambahan
                                    const additionalInfoBody = document.getElementById('addhistory');

                                    if (data.informasi_tambahan && data.informasi_tambahan.length > 0) {
                                        data.informasi_tambahan.forEach((info, index) => {
                                            let alasanPenolakan = (index === data.informasi_tambahan.length - 1)
                                                ? info.alasan_penolakan
                                                : '-'; // hanya isi di baris terakhir

                                            let row = `
                                                <tr>
                                                    <td style="text-align: center">${index + 1}</td>
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
                                        additionalInfoBody.innerHTML = `
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada informasi tambahan</td>
                                            </tr>
                                        `;
                                    }

                                    // Aktifkan DataTable setelah data ditambahkan
                                    $('#detaildataTableModal').DataTable({
                                        columnDefs: [
                                            {className: 'dt-head-center', targets: 0},
                                            {className: 'dt-head-left', targets: 1},

                                            {className: 'dt-body-center', targets: 0},
                                            {className: 'dt-body-left', targets: 1},
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
                                        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                                    });

                                    // Pastikan modal terbuka setelah data dimuat
                                    $('#suratDinasModal').modal('show');
                                },
                                error: function (xhr, status, error) {
                                    console.error("Error fetching data:", error);
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Gagal mengambil data surat dinas.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            });
                        });
                    });


                    $(document).ready(function () {

                        // Fungsi untuk mendapatkan tanggal hari ini
                        function getTodayDate() {
                            const today = new Date();
                            const year = today.getFullYear();
                            const month = String(today.getMonth() + 1).padStart(2, '0');
                            const day = String(today.getDate()).padStart(2, '0');
                            return `${year}-${month}-${day}`; // Format YYYY-MM-DD
                        }

                        function formatDateToStartOfDay(date) {
                            const d = new Date(date);
                            d.setHours(0, 0, 0, 0);
                            return formatLocalDate(d, 'start');
                        }

                        function formatDateToEndOfDay(date) {
                            const d = new Date(date);
                            d.setHours(23, 59, 59, 999);
                            return formatLocalDate(d, 'end');
                        }


                            // Fungsi utama untuk memformat waktu lokal dengan opsi jam kustom
                        function formatLocalDate(date, type = 'default') {
                            const localDate = new Date(date); // aman karena ini sudah Date, bukan string

                            const year = localDate.getFullYear();
                            const month = String(localDate.getMonth() + 1).padStart(2, '0');
                            const day = String(localDate.getDate()).padStart(2, '0');
                            const hours = String(localDate.getHours()).padStart(2, '0');
                            const minutes = String(localDate.getMinutes()).padStart(2, '0');
                            const seconds = String(localDate.getSeconds()).padStart(2, '0');

                            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                        }



                        // Fungsi untuk memuat jumlah data
                        function loadCounts(startDate, endDate) {
                            const today = getTodayDate();
                            const formattedStartDate = startDate ? formatDateToStartOfDay(startDate) : formatDateToStartOfDay(today);
                            const formattedEndDate = endDate ? formatDateToEndOfDay(endDate) : formatDateToEndOfDay(today);

                            // Tampilkan placeholder sementara
                            $('.jumlah-pengajuan').text('...');
                            $('.jumlah-disetujui').text('...');
                            $('.jumlah-menunggu').text('...');
                            $('.jumlah-ditolak').text('...');
                            $('.jumlah-kendaraan-tersedia').text('...');
                            $('.jumlah-kendaraan-digunakan').text('...');
                            

                            // AJAX request untuk mengambil count data
                            $.ajax({
                                url: `/dashboard-kendaraan-dinas/get-data-card`,
                                method: 'GET',
                                dataType: 'json',
                                data: {
                                    start_date: formattedStartDate,
                                    end_date: formattedEndDate,
                                },
                                success: function (response) {
                                    console.log('Response from server:', response); // Debugging: Lihat data yang diterima

                                    // Validasi data yang diterima
                                    if (response.success && response.data) {
                                        const data = response.data;

                                        // Pastikan semua data yang diperlukan ada
                                        const counts = {
                                            pengajuan: data.suratKendaraan?.count ?? 0,
                                            disetujui: data.suratKendaraanDisetujui?.count ?? 0,
                                            menunggu: data.suratKendaraanMenunggu?.count ?? 0,
                                            ditolak: data.suratKendaraanDitolak?.count ?? 0,
                                            kendaraanTersedia: data.kendaraanDinasTersedia.count ?? 0,
                                            kendaraanDigunakan: data.kendaraanDinasSedangDigunakan.count ?? 0
                                        };

                                        console.log('Counts calculated:', counts); // Debugging: Lihat hasil perhitungan

                                        // Update elemen DOM hanya setelah semua data siap
                                        $('.jumlah-pengajuan').text(counts.pengajuan);
                                        $('.jumlah-disetujui').text(counts.disetujui);
                                        $('.jumlah-menunggu').text(counts.menunggu);
                                        $('.jumlah-ditolak').text(counts.ditolak);
                                        $('.jumlah-kendaraan-tersedia').text(counts.kendaraanTersedia);
                                        $('.jumlah-kendaraan-digunakan').text(counts.kendaraanDigunakan);
                                    } else {
                                        console.error('Invalid response format:', response); // Debugging: Log jika format respons tidak valid
                                        // Jika tidak ada data ditemukan atau format tidak valid, tampilkan 0
                                        $('.jumlah-pengajuan').text(0);
                                        $('.jumlah-disetujui').text(0);
                                        $('.jumlah-menunggu').text(0);
                                        $('.jumlah-ditolak').text(0);
                                        $('.jumlah-kendaraan-tersedia').text(0);
                                        $('.jumlah-kendaraan-digunakan').text(0);
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error('Error fetching counts:', error); // Debugging: Log error
                                    alert('Terjadi kesalahan saat mengambil data count.');
                                    // Reset nilai menjadi 0 jika terjadi error
                                    $('.jumlah-pengajuan').text(0);
                                    $('.jumlah-disetujui').text(0);
                                    $('.jumlah-menunggu').text(0);
                                    $('.jumlah-ditolak').text(0);
                                }
                            });
                        }

                        // Inisialisasi Flatpickr dengan event onChange untuk memuat count data
                        flatpickr("#date-range-picker", {
                            mode: "range",
                            dateFormat: "Y-m-d",
                            locale: "id",
                            onValueUpdate: function(selectedDates, dateStr, instance) {
                                if (selectedDates.length === 2) {
                                    const start = flatpickr.formatDate(selectedDates[0], "Y-m-d");
                                    const end = flatpickr.formatDate(selectedDates[1], "Y-m-d");
                                    instance._input.value = `${start} s/d ${end}`;
                                }
                            },
                            onChange: function (selectedDates, dateStr, instance) {
                                if (selectedDates.length === 2) {
                                    const startDate = formatLocalDate(selectedDates[0], 'start'); 
                                    const endDate = formatLocalDate(selectedDates[1], 'end'); 

                                    console.log("Start Date:", startDate);
                                    console.log("End Date:", endDate);

                                    // Panggil fungsi untuk memuat data
                                    loadCounts(startDate, endDate);
                                }
                            },
                        });

                        // Peta warna berdasarkan nilai
                        const badgeColorMap = {};
                        // Custom palett
                        const badgeColors = [
                            'danger', 'secondary', 'dark', 'pink', 'purple', 'orange', 'brown'
                        ];

                        let badgeColorIndex = 0;

                        // Fungsi generate warna konsisten untuk teks tertentu
                        function getBadgeColor(value) {
                            if (!badgeColorMap[value]) {
                                badgeColorMap[value] = badgeColors[badgeColorIndex % badgeColors.length];
                                badgeColorIndex++;
                            }
                            return badgeColorMap[value];
                        }

                        // Fungsi untuk memuat data tabel kendaraan dinas
                        function loadTableDataKendaraan(statusFilter, startDate, endDate) {
                            const today = getTodayDate();
                            const formattedStartDate = startDate ? formatDateToStartOfDay(startDate) : formatDateToStartOfDay(today);
                            const formattedEndDate = endDate ? formatDateToEndOfDay(endDate) : formatDateToEndOfDay(today);

                            // Reset tabel DataTable sebelum memuat data baru
                            let table = $('#dataTableKendaraan').DataTable();
                            table.clear();

                            $.ajax({
                                url: `/dashboard-kendaraan-dinas/get-data-card`,
                                method: 'GET',
                                dataType: 'json',
                                data: {
                                    start_date: formattedStartDate,
                                    end_date: formattedEndDate,
                                },
                                success: function (response) {
                                    let filteredData = [];
                                    if (statusFilter === 'ready') {
                                        filteredData = response.data.kendaraanDinasTersedia.data || [];
                                    } else if (statusFilter === 'occupied') {
                                        filteredData = response.data.kendaraanDinasSedangDigunakan.data || [];
                                    } else {
                                        filteredData = response.data.suratKendaraan.data || [];
                                    }

                                    const jenisKendaraanMapping = {
                                        '1': 'Kantor',
                                        '2': 'Pribadi',
                                        '3': 'Taxi'
                                    };

                                    console.log("Filtered Data:", filteredData);

                                    filteredData.forEach(function (item, index) {
                                        const jenisKendaraan = jenisKendaraanMapping[item.jenis_kendaraan] || item.jenis_kendaraan;

                                        let tanggalDigunakan = '-';
                                        let suratKendaraanDinas = '-';

                                        if (item.surat_details && item.surat_details.length > 0) {
                                            tanggalDigunakan = item.surat_details.map(surat => {
                                                const tgl = surat.tanggal_penggunaan || '-';
                                                const badgeClass = getBadgeColor(tgl);
                                                return `<span class="badge badge-${badgeClass}">${tgl}</span>`;
                                            }).join(' ');

                                            suratKendaraanDinas = item.surat_details.map(surat => {
                                                const no = surat.no_surat || '-';
                                                const tgl = surat.tanggal_penggunaan || '-';
                                                const badgeClass = getBadgeColor(tgl); // warna mengikuti tanggal
                                                return `<span class="badge badge-${badgeClass}">${no}</span>`;
                                            }).join(' ');
                                        }

                                        table.row.add([
                                            index + 1,
                                            jenisKendaraan,
                                            item.nomor_kendaraan,
                                            item.kapasitas_kendaraan,
                                            tanggalDigunakan,
                                            suratKendaraanDinas
                                        ]);
                                    });

                                    table.draw();
                                    setTimeout(() => {
                                        table.columns.adjust().responsive?.recalc();
                                    }, 200);
                                },
                                error: function (xhr, status, error) {
                                    console.error('Error fetching table data:', error);
                                }
                            });
                        }

                        // Fungsi untuk memuat data tabel surat kendaraan dinas
                        function loadTableData(statusFilter, startDate, endDate) {
                            const today = getTodayDate();
                            const formattedStartDate = startDate ? formatDateToStartOfDay(startDate) : formatDateToStartOfDay(today);
                            const formattedEndDate = endDate ? formatDateToEndOfDay(endDate) : formatDateToEndOfDay(today);

                            // Reset tabel DataTable sebelum memuat data baru
                            let table = $('#dataTable').DataTable();
                            table.clear();

                            // AJAX request untuk mengambil data tabel
                            $.ajax({
                                url: `/dashboard-kendaraan-dinas/get-data-card`,
                                method: 'GET',
                                dataType: 'json',
                                data: {
                                    start_date: formattedStartDate,
                                    end_date: formattedEndDate,
                                },
                                success: function (response) {
                                    if (response.success && response.data) {
                                        // Pilih data berdasarkan status yang diminta
                                        let filteredData = [];
                                        if (statusFilter === 'approved') {
                                            filteredData = response.data.suratKendaraanDisetujui.data || [];
                                        } else if (statusFilter === 'pending') {
                                            filteredData = response.data.suratKendaraanMenunggu.data || [];
                                        } else if (statusFilter === 'rejected') {
                                            filteredData = response.data.suratKendaraanDitolak.data || [];
                                        } else if (statusFilter === 'ready') {
                                            filteredData = response.data.kendaraanDinasTersedia.data || []; 
                                        } else if (statusFilter === 'occupied'){
                                            filteredData = response.data.kendaraanDinasDigunakan.data || [];
                                        }else{
                                            filteredData = response.data.suratKendaraan.data || [];
                                        }

                                        // Mapping status level ke tampilan
                                        const statusMapping = {
                                            'Level 1': 'Menunggu Persetujuan Ka.Dept',
                                            'Level 2': 'Sudah Disetujui Ka.Dept',
                                            'Level 3': 'Sudah Disetujui Ka.Sie General Services',
                                            'Level 4': 'Sudah Disetujui',
                                            'Level 0': 'Ditolak',
                                        };

                                        // Masukkan data ke dalam DataTable
                                        if (filteredData.length > 0) {
                                            filteredData.forEach(function (item, index) {
                                            // Mapping status level ke tampilan
                                            const mappedStatus = statusMapping[item.status] || item.status;

                                            // Ambil tujuan dan filter yang valid (tidak null/empty)
                                            const tujuanList = [item.tujuan_penggunaan_1, item.tujuan_penggunaan_2, item.tujuan_penggunaan_3]
                                                                .filter(tujuan => tujuan && tujuan.trim() !== '');

                                            // Render tujuan jadi HTML seperti badge / span dengan nomor
                                            let tujuanHTML = '';
                                            if (tujuanList.length > 0) {
                                                tujuanHTML += `<div class="tujuan-container-minimal"><div class="tujuan-list-minimal">`;
                                                tujuanList.forEach((tujuan, i) => {
                                                    tujuanHTML += `
                                                        <span class="tujuan-item-minimal">
                                                            <span class="tujuan-number-minimal">${i + 1}</span>
                                                            ${tujuan}
                                                        </span>
                                                    `;
                                                });
                                                tujuanHTML += `</div></div>`;
                                            } else {
                                                tujuanHTML = `
                                                    <div class="no-tujuan">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <span>Tidak ada tujuan</span>
                                                    </div>
                                                `;
                                            }

                                            table.row.add([
                                                index + 1,
                                                item.surat_kendaraan_dinas_id,
                                                tujuanHTML,
                                                item.jenis_kendaraan == 1 ? 'Kantor' :
                                                item.jenis_kendaraan == 2 ? 'Pribadi' :
                                                item.jenis_kendaraan == 3 ? 'Taxi' :
                                                item.jenis_kendaraan,
                                                mappedStatus,
                                                `<button type="button" 
                                                    class="btn btn-primary btn-sm" 
                                                    data-toggle="modal" 
                                                    data-target="#detailModalPenggunaan" 
                                                    data-nomor="${item.surat_kendaraan_dinas_id}">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </button>`
                                            ]);
                                        });

                                        } else {
                                            console.warn('Tidak ada data ditemukan untuk filter yang diterapkan.');
                                        }

                                        // Perbarui DataTable
                                        table.draw();
                                    } else {
                                        console.warn('Tidak ada data ditemukan.');
                                        table.draw(); // Tabel tetap kosong tetapi dirender ulang
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error('Error fetching table data:', error);
                                    alert('Terjadi kesalahan saat mengambil data tabel.');
                                }
                            });
                        }

                        // Event untuk menangani klik elemen dengan atribut data-status
                        $('#modalPengajuan').on('show.bs.modal', function (event) {
                            const relatedTarget = $(event.relatedTarget); // Elemen yang memicu modal
                            const statusFilter = relatedTarget.data('status'); // Ambil data-status dari elemen yang diklik

                            if (!statusFilter) {
                                console.warn('Data status tidak ditemukan. Pastikan elemen yang di-klik memiliki atribut data-status.');
                                return;
                            }

                            // Ambil instance Flatpickr
                            const dateRangeInstance = document.getElementById("date-range-picker")._flatpickr;

                            if (!dateRangeInstance) {
                                console.error('Flatpickr tidak ditemukan pada elemen #date-range-picker.');
                                return;
                            }

                            let startDate, endDate;
                            const selectedDates = dateRangeInstance.selectedDates;

                            if (selectedDates.length === 2) {
                                startDate = formatLocalDate(selectedDates[0], 'start');
                                endDate = formatLocalDate(selectedDates[1], 'end');
                            } else {
                                const today = new Date();
                                startDate = formatLocalDate(today, 'start');
                                endDate = formatLocalDate(today, 'end');
                            }

                            console.log('Start Date:', startDate);
                            console.log('End Date:', endDate);

                            // Panggil fungsi untuk memuat data tabel
                            loadTableData(statusFilter, startDate, endDate);
                        });

                        // Event untuk menangani klik elemen dengan atribut data-status kendaraan tersedia
                        $('#modalKendaraan').on('show.bs.modal', function (event) {
                            const relatedTarget = $(event.relatedTarget); // Elemen yang memicu modal
                            const statusFilter = relatedTarget.data('status'); // Ambil data-status dari elemen yang diklik

                            if (!statusFilter) {
                                console.warn('Data status tidak ditemukan. Pastikan elemen yang di-klik memiliki atribut data-status.');
                                return;
                            }

                            // Ambil instance Flatpickr
                            const dateRangeInstance = document.getElementById("date-range-picker")._flatpickr;

                            if (!dateRangeInstance) {
                                console.error('Flatpickr tidak ditemukan pada elemen #date-range-picker.');
                                return;
                            }

                            let startDate, endDate;
                            const selectedDates = dateRangeInstance.selectedDates;

                            if (selectedDates.length === 2) {
                                startDate = formatLocalDate(selectedDates[0], 'start');
                                endDate = formatLocalDate(selectedDates[1], 'end');
                            } else {
                                const today = new Date();
                                startDate = formatLocalDate(today, 'start');
                                endDate = formatLocalDate(today, 'end');
                            }

                            console.log('Start Date:', startDate);
                            console.log('End Date:', endDate);

                            loadTableDataKendaraan(statusFilter, startDate, endDate);
                        });

                    });
                });

                $(document).ready(function () {

                    flatpickr("#date-range-picker", {
                        mode: "range",
                        dateFormat: "Y-m-d",
                        locale: "id",
                        onValueUpdate: function(selectedDates, dateStr, instance) {
                            if (selectedDates.length === 2) {
                                const start = flatpickr.formatLocalDate(selectedDates[0], 'start');
                                const end = flatpickr.formatLocalDate(selectedDates[1], 'end');
                                instance._input.value = `${start} s/d ${end}`;
                            }
                        },
                        onChange: function (selectedDates, dateStr, instance) {
                            if (selectedDates.length === 2) {
                                const startDate = formatLocalDate(selectedDates[0], 'start');
                                const endDate = formatLocalDate(selectedDates[1], 'end');

                                // Panggil fungsi setelah pengguna memilih 2 tanggal
                                loadCounts(startDate, endDate);
                            }
                        },
                    });

                    function formatDateToStartOfDay(date) {
                        const d = new Date(date);
                        d.setHours(0, 0, 0, 0);
                        return formatLocalDate(d, 'start');
                    }

                    function formatDateToEndOfDay(date) {
                        const d = new Date(date);
                        d.setHours(23, 59, 59, 999);
                        return formatLocalDate(d, 'end');
                    }


                    function stripTimeFromDatetime(datetimeStr) {
                        return datetimeStr.split('T')[0];
                    }

                    function fetchData() {
                        const rawStartDate = startDateInput.val();
                        const rawEndDate = endDateInput.val();

                        if (rawStartDate && rawEndDate) {
                            const startDate = stripTimeFromDatetime(rawStartDate);
                            const endDate = stripTimeFromDatetime(rawEndDate);

                            const formattedStartDate = formatDateToStartOfDay(startDate);
                            const formattedEndDate = formatDateToEndOfDay(endDate);

                            $.ajax({
                                url: `/dashboard-kendaraan-dinas/get-data-card?start_date=${formattedStartDate}&end_date=${formattedEndDate}`,
                                method: 'GET',
                                dataType: 'json',
                                success: function (response) {
                                    if (response.success) {
                                        $('.jumlah-pengajuan').text(response.data.suratKendaraan?.length ?? 0);
                                        $('.jumlah-disetujui').text(response.data.suratKendaraanDisetujui ?? 0);
                                        $('.jumlah-menunggu').text(response.data.suratKendaraanMenunggu ?? 0);
                                        $('.jumlah-ditolak').text(response.data.suratKendaraanDitolak ?? 0);
                                    }
                                },
                                error: function (xhr) {
                                    console.error('Error:', xhr.responseText);
                                    $('.jumlah-pengajuan').text(0);
                                    $('.jumlah-disetujui').text(0);
                                    $('.jumlah-menunggu').text(0);
                                    $('.jumlah-ditolak').text(0);
                                }
                            });
                        }
                    }


                    // Event listener untuk perubahan pada input tanggal
                    startDateInput.change(fetchData);
                    endDateInput.change(fetchData);
                });

                function resetPage() {
                    location.reload(); // Reload halaman
                }

                // Inisialisasi Flatpickr
                flatpickr("#date-range-picker", {
                    mode: "range", // Mode range date picker
                    dateFormat: "Y-m-d", // Format tanggal (contoh: 2025-02-13)
                    locale: "id", // Opsional: Locale Indonesia
                    onValueUpdate: function(selectedDates, dateStr, instance) {
                            if (selectedDates.length === 2) {
                                const start = flatpickr.formatLocalDate(selectedDates[0], 'start');
                                const end = flatpickr.formatLocalDate(selectedDates[1], 'end');
                                instance._input.value = `${start} s/d ${end}`;
                            }
                        },
                    onClose: function (selectedDates, dateStr, instance) {
                        if (selectedDates.length === 2) { // Pastikan ada dua tanggal yang dipilih
                            // Format tanggal menjadi YYYY-MM-DD
                            const formattedStartDate = formatLocalDate(selectedDates[0], 'start');
                            const formattedEndDate = formatLocalDate(selectedDates[1], 'end');

                            // Tampilkan hasil format pada konsol
                            console.log("Start Date:", formattedStartDate); // Contoh: 2025-01-31
                            console.log("End Date:", formattedEndDate); // Contoh: 2025-02-20

                            // Gunakan tanggal yang sudah diformat untuk kebutuhan lainnya
                            // Contoh: Memperbarui input value atau mengirim ke fungsi lain
                            document.querySelector("#start-date").value = formattedStartDate;
                            document.querySelector("#end-date").value = formattedEndDate;
                        }
                    },
                });
        </script>
        </body>
    </div>
</div>
