<div class ="content-wrapper">
    <div class="container-fluid">
        <body>
            <div class="mt-3" id="root">
                <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $pengeluaranBarangs->count() }}</h3>
                        <p>Jumlah Pengajuan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-document"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lebih Banyak <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $pengeluaranBarangsDisetujui}}</h3>

                        <p>Jumlah Disetujui</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-document"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lebih Banyak <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $pengeluaranBarangsDisetujui}}</h3>

                        <p>Jumlah Menunggu</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-document"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lebih Banyak <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            <!-- ./col -->
            </div>

            <div class="card text-left mt-3">
            <div class="card-header" style="border-top: 5px solid  #5A6ACF;">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active" data-filter="harian">Harian</button>
                    <button type="button" class="btn btn-outline-primary" data-filter="bulanan">Bulanan</button>
                    <button type="button" class="btn btn-outline-primary" data-filter="tahunan">Tahunan</button>
                </div>
            </div>
            <h5 class="card-title mt-3 text-center">Diagram Kuantitas Pengeluaran Barang</h5>
            <div class="card-body">
                <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </body>

        <script>
            const dailyData = {!! $dailyData !!};
            const monthlyData = {!! $monthlyData !!};
            const yearlyData = {!! $yearlyData !!};
        
            const ctx = document.getElementById('barChart').getContext('2d');
        
            let barChart = new Chart(ctx, {
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
                        y: {
                            beginAtZero: true
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
        
                    // Update chart data
                    barChart.data.labels = selectedData.labels;
                    barChart.data.datasets[0].data = selectedData.data;
        
                    // Update chart
                    barChart.update();
                });
            });
        </script>
        
    

        </body>
    </div>
</div>
