

<div class ="content-wrapper">
    <div class="container-fluid">
        @foreach ($approvals as $approval)
            <div class="card shadow mb-4 mt-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label style="font-weight: bold;">No Pengajuan Barang : </label><br>
                                <span id="dataID">{{ $approval->pengeluaranBarang->pengeluaran_barang_id  }}</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                               
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label style="font-weight: bold;">Status : </label><br>
                                <span class="badge 
                                    {{ $approval->status_approval == 'Menunggu Persetujuan Ka.Dept GA' ? 'bg-warning' : 'bg-success' }}">
                                    {{ $approval->status_approval }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label style="font-weight: bold;">Tujuan : </label><br>
                                <span id="dataID">{{ $approval->pengeluaranBarang->tujuan_pengeluaran_barang  }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label style="font-weight: bold;">Jenis Kendaraan : </label><br>
                                <span id="dataID">{{ $approval->pengeluaranBarang->jenis_kendaraan  }}</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                               
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <button class="btn btn-success">Setujui</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($approval->pengeluaranBarang->barangKeluar as $index => $barang)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->jumlah_barang }}</td>
                                    <td>{{ $barang->satuan_barang }}</td>
                                    <td>{{ $barang->keterangan_barang }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>