<div class ="content-wrapper">
    <div class="container-fluid">
        <body>
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center" style="border-top: 5px solid #5A6ACF;">
                    <h5 class="card-title mb-0 flex-grow-1">Informasi Pengajuan Akumulasi Harian</h5>
                    <div class="d-flex w-auto align-items-center">
                       
                        <div class="me-3 mr-3">
                            <input type="text" id="start-date" class="form-control" placeholder="Dari" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'">
                        </div>
                        <div>
                            <input type="text" id="end-date" class="form-control" placeholder="Sampai" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'">
                        </div>
                        <div>    
                            <button class="btn btn-primary ml-3" id="refresh-button" onclick="resetPage()">
                                <i class="fa fa-undo" aria-hidden="true"></i> Reset
                            </button>
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
                                    <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modalPengajuan">Lebih Banyak <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                       <!-- Modal -->
                        <div class="modal fade" id="modalPengajuan" tabindex="-1" role="dialog" aria-labelledby="modalPengajuanLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
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
                                                                Menunggu Persetujuan Security
                                                            @elseif ($pengeluaranBarang->status == 'Level 5')
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
                                        <p><strong>Nomor Pengeluaran:</strong> <span id="nomorPengeluaranCard"></span></p>
                                        <!-- Card untuk Tabel Barang Keluar -->
                                        <div class="card">
                                            <div class="card-header bg-primary text-white">
                                                <h6 class="mb-0">Detail Barang Keluar</h6>
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
                                <a href="#" class="small-box-footer">Lebih Banyak <i class="fas fa-arrow-circle-right"></i></a>
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
                                <a href="#" class="small-box-footer">Lebih Banyak <i class="fas fa-arrow-circle-right"></i></a>
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
                                <a href="#" class="small-box-footer">Lebih Banyak <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                </div>
            </div>

            <div>
            <div class="row">
            <!-- Bagian Kiri - Diagram Batang dengan Filter -->
            <div class="@if(Auth::check() && in_array(Auth::user()->level, ['Level 4', 'Level 5'])) col-md-6 @else col-md-12 @endif">
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
            @if(Auth::check() && in_array(Auth::user()->level, ['Level 5', 'Level 4']))
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

                var table = $('#detaildataTableModal').DataTable({
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

                            const tbody = document.getElementById('detailBody');
                            const additionalInfoBody = document.getElementById('additionalInfoBody');

                            tbody.innerHTML = '';
                            additionalInfoBody.innerHTML = '';

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

                            const tingkatMapping = {
                                "Level 1": "Civitas",
                                "Level 2": "PIC/Ka.Sie",
                                "Level 3": "Ka.Dept.Ybs",
                                "Level 4": "Ka.Dept.GA",
                                "Level 5": "Security"
                            };

                            const approvMapping = {
                                "Level 1": "Mengeluarkan",
                                "Level 2": "Membawa",
                                "Level 3": "Menyetujui",
                                "Level 4": "Mengetahui",
                                "Level 5": "Memeriksa"
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
            });

            $(document).ready(function () {
                const startDateInput = $('#start-date');
                const endDateInput = $('#end-date');

                function formatDateToStartOfDay(dateString) {
                    return `${dateString} 00:00:00`; // Format YYYY-MM-DD 00:00:00
                }

                function fetchData() {
                    const startDate = startDateInput.val();
                    const endDate = endDateInput.val();

                    if (startDate && endDate) {
                        const formattedStartDate = formatDateToStartOfDay(startDate);
                        const formattedEndDate = formatDateToStartOfDay(endDate);

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
        </script>
        
        </body>
    </div>
</div>
