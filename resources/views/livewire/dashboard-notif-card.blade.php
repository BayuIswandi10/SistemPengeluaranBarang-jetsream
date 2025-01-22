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
            
            .card {
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

            .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            }

            .card-header {
            font-weight: reguler;
            }
            </style>
        </head>
        <body>
            <div class="card" style="background-color: white; border-top: 5px solid #5A6ACF;">
                <div class="card-header" style="font-size:16">Jumlah Pengajuan</div>
                <div style="font-size: 40px; font-weight: bold; text-align: left;">10</div>
                </div>

                <div class="card" style="background-color: white; border-top: 5px solid #149D52;">
                <div class="card-header">Jumlah Disetujui</div>
                <div style="font-size: 40px; font-weight: bold; text-align: left;">10</div>
                </div>

                <div class="card" style="background-color: #white; border-top: 5px solid #F99C30;">
                <div class="card-header">Jumlah Menunggu</div>
                <div style="font-size: 40px; font-weight: bold; text-align: left;">10</div>
            </div>

            <div>
                <div class="card-body mt-5">
                    <div class="chart">
                        <canvas id="barChart" style="mt-5 min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                
                // Dummy data for surat barang keluar per hari
                const labels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                const data = [5, 8, 12, 7, 9, 6, 4]; // Dummy jumlah surat barang keluar

                // Bar Chart Configuration
                const ctx = document.getElementById('barChart').getContext('2d');
                const barChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Surat Barang Keluar',
                            data: data,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(255, 159, 64, 0.6)',
                                'rgba(201, 203, 207, 0.6)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(201, 203, 207, 1)'
                            ],
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
            </script>
        </body>
        
    </div>
</div>
