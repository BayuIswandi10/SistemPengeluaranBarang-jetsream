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
        </body>
    </div>
</div>
