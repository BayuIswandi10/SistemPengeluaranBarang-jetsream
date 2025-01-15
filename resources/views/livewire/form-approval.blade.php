

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
                                    {{ in_array($approval->status_approval, ['Level 1', 'Level 2', 'Level 3']) ? 'bg-warning' : 'bg-success' }}">
                                    @if($approval->status_approval == 'Level 1')
                                        Menunggu Persetujuan PIC/Ka.Sie
                                    @elseif($approval->status_approval == 'Level 2')
                                        Menunggu Persetujuan Ka.Dept Ybs
                                    @elseif($approval->status_approval == 'Level 3')
                                        Menunggu Persetujuan Ka.Dept GA
                                    @else
                                        {{ $approval->status_approval }}
                                    @endif
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
                                <form action="{{ route('approval.update', $approval->approval_id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button class="btn btn-success" type="submit" 
                                        @if($approval->status_approval == 'Level 5') disabled @endif>
                                        @if($approval->status_approval == 'Level 5') Sudah Level 5 @else Setujui @endif
                                    </button>
                                </form>
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