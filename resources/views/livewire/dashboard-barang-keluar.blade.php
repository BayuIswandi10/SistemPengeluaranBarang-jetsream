<div class ="content-wrapper">
    <div class="container-fluid">
        <body>
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center" style="border-top: 5px solid #5A6ACF;">

                @if ($user->level === 'Ka.Dept')
                    <div class="d-flex border rounded overflow-hidden" style="width: fit-content;">
                        <a href="{{ route('dashboard-barang-keluar') }}"
                        class="d-flex align-items-center justify-content-center px-3 py-2 {{ request()->is('dashboard-barang-keluar') ? 'text-white' : 'text-dark bg-white' }}"
                        style="background-color: {{ request()->is('dashboard-barang-keluar') ? '#5A6ACF' : 'white' }};
                                text-decoration: none; width: 300px; white-space: nowrap; font-weight: 400;">
                            Barang Keluar
                        </a>
                        <a href="{{ route('dashboard-kendaraan-dinas') }}"
                        class="d-flex align-items-center justify-content-center px-3 py-2 {{ request()->is('dashboard-kendaraan-dinas') ? 'text-white' : 'text-dark bg-white' }}"
                        style="background-color: {{ request()->is('dashboard-kendaraan-dinas') ? '#5A6ACF' : 'white' }};
                                text-decoration: none; border-left: 1px solid #ccc; width: 300px; white-space: nowrap; font-weight: 400;">
                            Penggunaan Kendaraan Dinas
                        </a>
                    </div>
                @else
                    <h5 class="m-0 font-weight-bold text-primary">Informasi Pengajuan Akumulasi Harian</h5>
                @endif

                    <div class="d-flex align-items-center w-100 justify-content-end">
                        <!-- Input Tanggal -->
                        <div class="row g-3">
                        <!-- Input "Range Date FlatPicker" -->
                        <div class="col-auto">
                            <div class="input-group">
                                <input type="text" id="date-range-picker" class="form-control" placeholder="Pilih Rentang Tanggal">
                            </div>
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
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
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
                            <div class="modal-dialog modal-xl" role="document">
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
                                                <h6 class="mb-0">Informasi Tambahan</h6>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered">
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
                    </div>
                </div>
            </div>

            <div>
            <div class="row">
            <!-- Bagian Kiri - Diagram Batang dengan Filter -->
            <div class="@if(Auth::check() && in_array(Auth::user()->level, ['Ka.Dept', 'Security'])) col-md-6 @else col-md-12 @endif">
                <div class="card">
                    <div class="card-header" style="border-top: 5px solid #5A6ACF; padding-left: 10;">
                        <div class="btn-group" role="group" style="margin-left: 0;">
                            <button type="button" class="btn btn-outline-primary active" data-filter="harian">Harian</button>
                            <button type="button" class="btn btn-outline-primary" data-filter="bulanan">Bulanan</button>
                            <button type="button" class="btn btn-outline-primary" data-filter="tahunan">Tahunan</button>
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
            @if(Auth::check() && in_array(Auth::user()->level, ['Ka.Dept', 'Security']))
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="border-top: 5px solid  #5A6ACF;">
                        <h5 class="card-title text-center">Distribusi Pengeluaran Barang Berdasarkan Departemen</h5>
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

            // 🔹 Inisialisasi Bar Chart
            let barChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: dailyData.labels,
                    datasets: [{
                        label: 'Jumlah Surat Barang Keluar',
                        data: dailyData.data,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
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
                    let pieChart = new Chart(ctxPie, {
                        type: 'pie',
                        data: {
                            labels: Object.keys(pieData),
                            datasets: [{
                                label: 'Departemen',
                                data: Object.values(pieData),
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.6)',
                                    'rgba(54, 162, 235, 0.6)',
                                    'rgba(255, 206, 86, 0.6)',
                                    'rgba(75, 192, 192, 0.6)',
                                    'rgba(153, 102, 255, 0.6)',
                                    'rgba(255, 159, 64, 0.6)'
                                ],
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
                        }
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
                    barChart.update();
                });
            });

            document.addEventListener('DOMContentLoaded', () => {
                var table = $('#dataTable').DataTable({
                    columnDefs: [
                        {className: 'dt-body-center', targets: 0},
                        {className: 'dt-head-center', targets: 0},
                        {className: 'dt-body-center', targets: 5},
                        {className: 'dt-head-center', targets: 5}
                    ],
                    scrollX: false,
                    responsive: true
                });

                $('#detailModal').on('show.bs.modal', function (event) {
                    const button = $(event.relatedTarget); // Button yang diklik
                    const nomor = button.data('nomor'); // Nomor pengeluaran barang
                    document.getElementById('nomorPengeluaranCard').innerText = nomor;
                    $.ajax({
                        url: "/pengeluaran/detail",
                        method: "POST",
                        data: { pengeluaran_barang_id: nomor, "_token": "{{ csrf_token() }}" },
                        success: function (data) {
                            // console.log("Response dari server:", data); // Debugging
                            document.getElementById('kategoriBarangCard').innerText = data.kategori_pengeluaran === 1 ? 'Scrap' : 'Non Scrap';
                            document.getElementById('nomorPolisiCard').innerText = data.no_polisi || '-';
                            const tbody = document.getElementById('detailBody');
                            const additionalInfoBody = document.getElementById('additionalInfoBody');

                            tbody.innerHTML = '';
                            additionalInfoBody.innerHTML = '';

                            // Hapus DataTable sebelum menambahkan data baru
                            if ($.fn.DataTable.isDataTable('#detaildataTableModal')) {
                                $('#detaildataTableModal').DataTable().clear().destroy();
                            }

                            // Validasi data barang_keluar
                            if (data.barang_keluar && data.barang_keluar.length > 0) {
                                tbody.innerHTML = data.barang_keluar.map((item, index) => `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${nomor}</td>
                                        <td>${item.nama_barang}</td>
                                        <td>${item.jumlah_barang}</td>
                                        <td>${item.satuan_barang}</td>
                                        <td>${item.keterangan_barang}</td>
                                    </tr>
                                `).join('');
                            } else {
                                tbody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data barang keluar</td></tr>';
                            }

                            // Inisialisasi ulang DataTable
                            $('#detaildataTableModal').DataTable({
                                responsive: true,
                                scrollX: false,
                                pageLength: 5,
                                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                                destroy: true
                            });

                            const tingkatMapping = {
                                "Level 1": "Civitas",
                                "Level 2": "PIC/Ka.Sie",
                                "Level 3": "Ka.Dept.Ybs",
                                "Level 4": "Ka.Dept.GA",
                                "Level 5": "Finance",
                                "Level 6": "Security"
                            };
                            const approvMapping = {
                                "Level 1": "Mengeluarkan",
                                "Level 2": "Membawa",
                                "Level 3": "Menyetujui",
                                "Level 4": "Mengetahui",
                                "Level 5": "Menerima",
                                "Level 6": "Memeriksa"
                            };


                            // Validasi data informasi_tambahan
                            if (data.informasi_tambahan && data.informasi_tambahan.length > 0) {
                                additionalInfoBody.innerHTML = data.informasi_tambahan.map((info, index) => `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${info.nama}</td>
                                        <td>${tingkatMapping[info.tingkatan] || info.tingkatan}</td>
                                        <td>${info.departemen}</td>
                                        <td>${approvMapping[info.status] || info.status}</td>
                                    </tr>
                                `).join('');
                            } else {
                                additionalInfoBody.innerHTML = '<tr><td colspan="5" class="text-center">Tidak ada informasi tambahan</td></tr>';
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


                $(document).ready(function () {
                    // Fungsi untuk mendapatkan tanggal hari ini
                    function getTodayDate() {
                        const today = new Date();
                        const year = today.getFullYear();
                        const month = String(today.getMonth() + 1).padStart(2, '0');
                        const day = String(today.getDate()).padStart(2, '0');
                        return `${year}-${month}-${day}`; // Format YYYY-MM-DD
                    }

                    // Fungsi untuk memformat tanggal ke awal hari
                    function formatDateToStartOfDay(dateString) {
                        return `${dateString} 00:00:00`; // Format YYYY-MM-DD 00:00:00
                    }

                    // Fungsi untuk memformat tanggal ke akhir hari
                    function formatDateToEndOfDay(dateString) {
                        return `${dateString} 23:59:59`; // Format YYYY-MM-DD 23:59:59
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
                            url: `/dashboard/get-data-card`,
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
                        mode: "range", // Mode range date picker
                        dateFormat: "Y-m-d", // Format tanggal
                        locale: "id", // Opsional: Locale Indonesia
                        onChange: function (selectedDates, dateStr, instance) {
                            // Hanya jalankan jika kedua tanggal (range) sudah dipilih
                            if (selectedDates.length === 2) {
                                const startDate = selectedDates[0].toISOString().split('T')[0]; // Format start date ke YYYY-MM-DD
                                const endDate = selectedDates[1].toISOString().split('T')[0];   // Format end date ke YYYY-MM-DD

                                console.log("Start Date:", startDate); // Debug tanggal mulai
                                console.log("End Date:", endDate);   // Debug tanggal akhir

                                // Panggil fungsi untuk memuat count data
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
                            url: `/dashboard/get-data-card`,
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
                                        'Level 4': 'Menunggu Persetujuan Finance/Security',
                                        'Level 5': 'Menunggu Persetujuan Security',
                                        'Level 6': 'Sudah Disetujui',
                                        'Level 0': 'Ditolak',
                                    };

                                    // Masukkan data ke dalam DataTable
                                    if (filteredData.length > 0) {
                                        filteredData.forEach(function (item, index) {
                                            const mappedStatus = statusMapping[item.status] || item.status; // Gunakan mapping jika status dikenali

                                            table.row.add([
                                                index + 1, // Kolom 1: No Urut
                                                item.pengeluaran_barang_id, // Kolom 2: Nomor Pengeluaran Barang
                                                item.tujuan_pengeluaran_barang, // Kolom 3: Tujuan
                                                item.jenis_kendaraan, // Kolom 4: Jenis Kendaraan
                                                mappedStatus, // Kolom 5: Status (dengan mapping)
                                                `<button type="button" 
                                                    class="btn btn-primary btn-sm" 
                                                    data-toggle="modal" 
                                                    data-target="#detailModal" 
                                                    data-nomor="${item.pengeluaran_barang_id}">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </button>` // Kolom 6: Aksi
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
                            return; // Jika tidak ada status, hentikan
                        }

                        // Ambil instance Flatpickr yang sudah ada
                        const dateRangeInstance = document.getElementById("date-range-picker")._flatpickr;

                        if (!dateRangeInstance) {
                            console.error('Flatpickr tidak ditemukan pada elemen #date-range-picker.');
                            return; // Jika Flatpickr belum diinisialisasi, hentikan
                        }

                        let startDate, endDate;
                        const selectedDates = dateRangeInstance.selectedDates; // Ambil tanggal yang dipilih

                        if (selectedDates.length === 2) {
                            // Format tanggal menjadi YYYY-MM-DD jika ada yang dipilih
                            startDate = selectedDates[0].toISOString().split('T')[0];
                            endDate = selectedDates[1].toISOString().split('T')[0];
                        } else {
                            // Default ke hari ini jika tidak ada tanggal yang dipilih
                            const today = new Date();
                            startDate = today.toISOString().split('T')[0];
                            endDate = today.toISOString().split('T')[0];
                        }

                        console.log('Start Date:', startDate); // Debug tanggal mulai
                        console.log('End Date:', endDate); // Debug tanggal akhir

                        // Panggil fungsi untuk memuat data tabel
                        loadTableData(statusFilter, startDate, endDate);
                    });

                });
            });

            $(document).ready(function () {
                const startDateInput = $('#start-date');
                const endDateInput = $('#end-date');

                function formatDateToStartOfDay(dateString) {
                    return `${dateString} 00:00:00`; // Format YYYY-MM-DD 00:00:00
                }

                // Fungsi untuk memformat tanggal ke akhir hari
                function formatDateToEndOfDay(dateString) {
                    return `${dateString} 23:59:59`; // Format YYYY-MM-DD 23:59:59
                }

                function fetchData() {
                    const startDate = startDateInput.val();
                    const endDate = endDateInput.val();

                    if (startDate && endDate) {
                        const formattedStartDate = formatDateToStartOfDay(startDate);
                        const formattedEndDate = formatDateToEndOfDay(endDate);

                        $.ajax({
                            url: `/dashboard/get-data-card?start_date=${formattedStartDate}&end_date=${formattedEndDate}`,
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
