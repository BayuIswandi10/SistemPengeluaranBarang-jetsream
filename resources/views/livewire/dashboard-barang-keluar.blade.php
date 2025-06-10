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
            border-color: #5a6acf !important;
            }

            .btn-outline-primary.custom-color:hover,
            .btn-outline-primary.custom-color:focus,
            .btn-outline-primary.custom-color:active,
            .btn-outline-primary.custom-color.active {
            background-color: #5A6ACF !important;
            color: white !important;
            border-color: #5A6ACF !important;
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
                                <input type="text" id="date-range-picker" class="form-control" placeholder="Pilih rentang tanggal surat dibuat">
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
                                    <h3 class="jumlah-pengajuan">{{ $pengeluaranBarangs->count() ?? 0 }}</h3>
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
                                    <h3  class="jumlah-disetujui">{{ $pengeluaranBarangsDisetujui ?? 0 }}</h3>
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
                                    <h3  class="jumlah-menunggu">{{ $pengeluaranBarangsMenunggu ?? 0 }}</h3>
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
                                    <h3 class="jumlah-ditolak">{{ $pengeluaranBarangsDitolak ?? 0 }}</h3>
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
                                                    <th>Nomor Pengeluaran Barang</th>
                                                    <th>Tujuan</th>
                                                    <th>Jenis Kendaraan</th>
                                                    <th>Status Persetujuan</th>
                                                    <th>Detail</th>
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
                                                            <!-- Button detail -->
                                                            <button 
                                                                type="button" 
                                                                class="btn btn-primary btn-sm" 
                                                                data-toggle="modal" 
                                                                data-target="#detailModal" 
                                                                data-nomor="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
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
                    </div>
                </div>
            </div>

            <div class="row">
            <!-- Bagian Kiri - Diagram Batang dengan Filter -->
            <div class="@if(Auth::check() && in_array(Auth::user()->level, ['Ka.Dept', 'Security', 'Super Admin'])) col-md-6 @else col-md-12 @endif">
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
            @if(Auth::check() && in_array(Auth::user()->level, ['Ka.Dept', 'Security','Super Admin']))
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="border-top: 5px solid  #5A6ACF;">
                        <h6 class="m-0 font-weight-bold" style="flex-grow: 1; color: #5A6ACF;" >Berdasarkan Asal Departemen</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>


        </body>

        <script>
            const dailyData = {!! $dailyData !!};
            const monthlyData = {!! $monthlyData !!};
            const yearlyData = {!! $yearlyData !!};
            const pieData = {!! $pieData !!};

           // Ambil elemen canvas untuk Bar Chart
            const ctxBar = document.getElementById('barChart').getContext('2d');
            console.log(dailyData);
            console.log(monthlyData);
            console.log(yearlyData);

            // Inisialisasi Bar Chart dengan 2 dataset
            let barChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: dailyData.labels,
                    datasets: [
                        {
                            label: 'Kategori Scrap',
                            data: dailyData.kategori_1, 
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Kategori Non-Scrap',
                            data: dailyData.kategori_0, 
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: false,
                            ticks: { autoSkip: false },
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            stacked: false
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });


           function generateColors(count) {
                const forbiddenHueRanges = [
                    [340, 10],  // sekitar merah
                    [200, 220], // sekitar biru
                ];

                const isForbiddenHue = (hue) => {
                    return forbiddenHueRanges.some(([start, end]) => {
                        if (start < end) return hue >= start && hue <= end;
                        return hue >= start || hue <= end; // untuk wrap around (misalnya 350-10)
                    });
                };

                const colors = [];
                let i = 0;

                while (colors.length < count) {
                    const hue = (i * 47) % 360; // angka primitif untuk variasi menyebar
                    if (!isForbiddenHue(hue)) {
                        colors.push(`hsla(${hue}, 70%, 60%, 0.6)`);
                    }
                    i++;
                }

                return colors;
            }


            const pieCanvas = document.getElementById('pieChart');
            if (pieCanvas) {
                try {
                    const ctxPie = pieCanvas.getContext('2d');

                    const pieLabels = Object.keys(pieData);
                    const pieValues = Object.values(pieData);
                    const isEmpty = pieValues.every(val => val === 0);

                    const dynamicColors = generateColors(pieLabels.length);

                    let pieChart = new Chart(ctxPie, {
                        type: 'pie',
                        data: {
                            labels: pieLabels,
                            datasets: [{
                                label: 'Departemen',
                                data: pieValues,
                                backgroundColor: dynamicColors,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: !isEmpty,
                                    position: 'right'
                                }
                            }
                        },
                        plugins: [{
                            id: 'emptyPieLabel',
                            beforeDraw(chart) {
                                if (isEmpty) {
                                    const { width, height } = chart;
                                    const ctx = chart.ctx;
                                    ctx.save();
                                    ctx.font = 'bold 16px sans-serif';
                                    ctx.fillStyle = '#6c757d';
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'middle';
                                    ctx.fillText('Belum Ada Data', width / 2, height / 2 + 20);
                                    ctx.restore();
                                }
                            }
                        }]
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
                    barChart.data.datasets[0].data = selectedData.kategori_0;
                    barChart.data.datasets[1].data = selectedData.kategori_1;

                    // 🔄 Update Chart
                    barChart.update();
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
                                        <td>${item.keterangan_barang ?? ''}</td>
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
                                "Level 1": "Mengeluarkan",
                                "Level 2": "Membawa",
                                "Level 3": "Menyetujui",
                                "Level 4": "Mengetahui",
                                "Level 5": "Menerima",
                                "Level 6": "Memeriksa"
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
                                    {className: 'dt-head-center', targets: 0},
                                    {className: 'dt-head-center', targets: 5},

                                    {className: 'dt-body-center', targets: 0},
                                    {className: 'dt-body-left', targets: 5}
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

                        // AJAX request untuk mengambil count data
                        $.ajax({
                            url: `/dashboard-barang-keluar/get-data-card`,
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
                                        pengajuan: data.pengeluaranBarangs?.count ?? 0,
                                        disetujui: data.pengeluaranBarangsDisetujui?.count ?? 0,
                                        menunggu: data.pengeluaranBarangsMenunggu?.count ?? 0,
                                        ditolak: data.pengeluaranBarangsDitolak?.count ?? 0,
                                    };

                                    console.log('Counts calculated:', counts); // Debugging: Lihat hasil perhitungan

                                    // Update elemen DOM hanya setelah semua data siap
                                    $('.jumlah-pengajuan').text(counts.pengajuan);
                                    $('.jumlah-disetujui').text(counts.disetujui);
                                    $('.jumlah-menunggu').text(counts.menunggu);
                                    $('.jumlah-ditolak').text(counts.ditolak);
                                } else {
                                    console.error('Invalid response format:', response); // Debugging: Log jika format respons tidak valid
                                    // Jika tidak ada data ditemukan atau format tidak valid, tampilkan 0
                                    $('.jumlah-pengajuan').text(0);
                                    $('.jumlah-disetujui').text(0);
                                    $('.jumlah-menunggu').text(0);
                                    $('.jumlah-ditolak').text(0);
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


                    // Fungsi untuk memuat data tabel
                    function loadTableData(statusFilter, startDate, endDate) {
                        const today = getTodayDate();
                        const formattedStartDate = startDate ? formatDateToStartOfDay(startDate) : formatDateToStartOfDay(today);
                        const formattedEndDate = endDate ? formatDateToEndOfDay(endDate) : formatDateToEndOfDay(today);

                        // Reset tabel DataTable sebelum memuat data baru
                        let table = $('#dataTable').DataTable();
                        table.clear();

                        // AJAX request untuk mengambil data tabel
                        $.ajax({
                            url: `/dashboard-barang-keluar/get-data-card`,
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
                                        filteredData = response.data.pengeluaranBarangsDisetujui.data || [];
                                    } else if (statusFilter === 'pending') {
                                        filteredData = response.data.pengeluaranBarangsMenunggu.data || [];
                                    } else if (statusFilter === 'rejected') {
                                        filteredData = response.data.pengeluaranBarangsDitolak.data || [];
                                    } else {
                                        filteredData = response.data.pengeluaranBarangs.data || []; // Tampilkan semua data jika statusFilter kosong
                                    }

                                   // Mapping status level ke tampilan
                                    const statusMapping = {
                                        'Level 1': 'Menunggu Persetujuan PIC/Ka.Sie',
                                        'Level 2': 'PIC/Ka.Sie Sudah Menyetujui',
                                        'Level 3': 'Menunggu Persetujuan Ka.Dept GA',
                                        'Level 4': null, // Akan ditentukan berdasarkan kategori_pengeluaran
                                        'Level 5': 'Menunggu Persetujuan Security',
                                        'Level 6': 'Sudah Disetujui',
                                        'Level 0': 'Ditolak',
                                    };

                                    // Mapping kategori_pengeluaran hanya untuk Level 4
                                    const kategoriMapping = {
                                        0: 'Menunggu Persetujuan Security',
                                        1: 'Menunggu Persetujuan Finance',
                                    };

                                    if (filteredData.length > 0) {
                                        filteredData.forEach(function (item, index) {
                                            let mappedStatus;

                                            if (item.status === 'Level 4') {
                                                // Pastikan kategori_pengeluaran tersedia dan valid
                                                const kategori = parseInt(item.kategori_pengeluaran);
                                                mappedStatus = kategoriMapping[kategori] || 'Menunggu Persetujuan (Kategori Tidak Dikenal)';
                                            } else {
                                                mappedStatus = statusMapping[item.status] || item.status;
                                            }

                                            table.row.add([
                                                index + 1,
                                                item.pengeluaran_barang_id,
                                                item.tujuan_pengeluaran_barang,
                                                item.jenis_kendaraan,
                                                mappedStatus,
                                                `<button type="button" 
                                                    class="btn btn-primary btn-sm" 
                                                    data-toggle="modal" 
                                                    data-target="#detailModal" 
                                                    data-nomor="${item.pengeluaran_barang_id}">
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


                });
            });

            $(document).ready(function () {
                const startDateInput = $('#start-date');
                const endDateInput = $('#end-date');
                
                const savedRange = localStorage.getItem("selectedDateRange");
                
                flatpickr("#date-range-picker", {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    locale: "id",
                    onChange: function (selectedDates, dateStr, instance) {
                        if (selectedDates.length === 2) {
                            const startDate = selectedDates[0].toISOString().split('T')[0];
                            const endDate = selectedDates[1].toISOString().split('T')[0];

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


                function fetchData() {
                    const startDate = startDateInput.val();
                    const endDate = endDateInput.val();

                    if (startDate && endDate) {
                        const formattedStartDate = formatDateToStartOfDay(startDate);
                        const formattedEndDate = formatDateToEndOfDay(endDate);

                        $.ajax({
                            url: `/dashboard-barang-keluar/get-data-card?start_date=${formattedStartDate}&end_date=${formattedEndDate}`,
                            method: 'GET',
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    // Update elemen card dengan data dari response
                                    $('.jumlah-pengajuan').text(response.data.pengeluaranBarangs.length || 0);
                                    $('.jumlah-disetujui').text(response.data.pengeluaranBarangsDisetujui || 0);
                                    $('.jumlah-menunggu').text(response.data.pengeluaranBarangsMenunggu || 0);
                                    $('.jumlah-ditolak').text(response.data.pengeluaranBarangsDitolak || 0);
                                }
                            },
                            error: function (xhr) {
                                console.error('Error:', xhr.responseText);
                                // Pastikan tetap menampilkan 0 jika terjadi kesalahan
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
                onClose: function (selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) { // Pastikan ada dua tanggal yang dipilih
                        // Format tanggal menjadi YYYY-MM-DD
                        const formattedStartDate = selectedDates[0].toISOString().split('T')[0];
                        const formattedEndDate = selectedDates[1].toISOString().split('T')[0];

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
