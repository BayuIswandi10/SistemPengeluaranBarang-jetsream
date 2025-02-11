<div class ="content-wrapper">
    <div class="container-fluid">
        <body>
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center" style="border-top: 5px solid #5A6ACF;">
                    <h5 class="card-title mb-0 flex-grow-1">Informasi Pengajuan Akumulasi Harian</h5>
                    <div class="d-flex w-auto align-items-center">
                        <div class="me-3">
                            <input type="text" id="start-date" class="form-control" placeholder="Dari" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'">
                        </div>
                        <div>
                            <input type="text" id="end-date" class="form-control" placeholder="Sampai" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'">
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
                                <a href="#" class="small-box-footer">Lebih Banyak <i class="fas fa-arrow-circle-right"></i></a>
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

            $(document).ready(function () {
                const startDateInput = $('#start-date');
                const endDateInput = $('#end-date');

                function fetchData() {
                    const startDate = startDateInput.val();
                    const endDate = endDateInput.val();

                    if (startDate && endDate) {
                        $.ajax({
                            url: `/dashboard/get-data-card?start_date=${startDate}&end_date=${endDate}`,
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

                startDateInput.change(fetchData);
                endDateInput.change(fetchData);
            });




        </script>
        
        </body>
    </div>
</div>
