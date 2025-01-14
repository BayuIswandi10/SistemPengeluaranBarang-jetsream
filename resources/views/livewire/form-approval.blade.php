{{-- <div class="container">
    @foreach ($pengeluaranBarangs as $pengeluaranBarang)
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5>No Pengeluaran: {{ $pengeluaranBarang->pengeluaran_barang_id }}</h5>
                        <p>Tujuan: {{ $pengeluaranBarang->tujuan_pengeluaran_barang }}</p>
                        <p>Jenis Kendaraan: {{ $pengeluaranBarang->jenis_kendaraan }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        @php
                            $status = $pengeluaranBarang->approval->last()->status_approval ?? 'Belum Ada Status';
                        @endphp
                        <span class="badge 
                            {{ $status == 'Menunggu Persetujuan Ka.Dept GA' ? 'bg-warning' : 'bg-success' }}">
                            {{ $status }}
                        </span>
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
                        @foreach ($pengeluaranBarang->barangKeluar as $index => $barang)
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
            <div class="card-footer text-end">
                <button class="btn btn-success">Setujui</button>
            </div>
        </div>
    @endforeach
</div> --}}

<div class="container">
    @foreach ($approvals as $approval)
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5>No Pengajuan Barang: {{ $approval->pengeluaranBarang->pengeluaran_barang_id }}</h5>
                        <p>Tujuan: {{ $approval->pengeluaranBarang->tujuan_pengeluaran_barang }}</p>
                        <p>Jenis Kendaraan: {{ $approval->pengeluaranBarang->jenis_kendaraan }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <span class="badge 
                            {{ $approval->status_approval == 'Menunggu Persetujuan Ka.Dept GA' ? 'bg-warning' : 'bg-success' }}">
                            {{ $approval->status_approval }}
                        </span>
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
            <div class="card-footer text-end">
                <button class="btn btn-success">Setujui</button>
            </div>
        </div>
    @endforeach
</div>
