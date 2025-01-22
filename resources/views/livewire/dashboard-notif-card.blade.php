<div class ="content-wrapper">
    <div class="container-fluid">
        <head>
            <style>
            .content-wrapper {
            display: flex; 
            flex-wrap: wrap;
            align-items: flex-start; 
            justify-content: flex-start;
            padding: 10px;
            height: 10%;;
            }
            
            .card-custom {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            border-radius: 5px;
            width: 180px;
            height: 115px;
            margin: 10px;
            display: inline-block;
            text-align: left;
            padding: 5px;
            }   

            .card-custom:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            }

            .card-header {
            font-weight: reguler;
            }
            </style>
        </head>
        <body>
            <div class="card-custom" style="background-color: white; border-top: 5px solid #5A6ACF;">
                <div class="card-header" style="font-size:16">Jumlah Pengajuan</div>
                <div style="font-size: 40px; font-weight: bold; text-align: left;">10</div>
                </div>

                <div class="card-custom" style="background-color: white; border-top: 5px solid #149D52;">
                <div class="card-header">Jumlah Disetujui</div>
                <div style="font-size: 40px; font-weight: bold; text-align: left;">10</div>
                </div>

                <div class="card-custom" style="background-color: white; border-top: 5px solid #F99C30;">
                <div class="card-header">Jumlah Menunggu</div>
                <div style="font-size: 40px; font-weight: bold; text-align: left;">10</div>
            </div>

            <div class="card mt-5">
            <div class="card-header">
                Diagram Kuantitas Pengeluaran Barang
                <select id="filter" class="float-end">
                    <option value="harian">Harian</option>
                    <option value="bulanan">Bulanan</option>
                    <option value="tahunan">Tahunan</option>
                </select>
            </div>
            <div class="card-body mt-5">
                <div class="chart">
                    <canvas id="barChart" style="mt-5 min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const dailyData = {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                data: [5, 8, 12, 7, 9, 6, 4]
            };

            const monthlyData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                data: [120, 150, 100, 180, 200, 170, 130, 160, 190, 220, 210, 250]
            };

            const yearlyData = {
                labels: ['2020', '2021', '2022', '2023', '2024'],
                data: [1500, 1800, 2000, 2300, 2500]
            };

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

            document.getElementById('filter').addEventListener('change', function () {
                const filterValue = this.value;
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
                barChart.update();
            });
        </script>

        </body>
        
    </div>
</div>
