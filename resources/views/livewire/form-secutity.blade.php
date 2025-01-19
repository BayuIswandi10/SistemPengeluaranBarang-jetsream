<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 mt-2 text-gray-800">Form Pengeluaran Barang</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pemeriksaan Barang</h6>
            </div>
            <div class="card-body">
                <table id="dataTable" class="table table-striped table-bordered nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nomor Pengeluaran Barang</th>
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
                                    <td>
                                        @if ($pengeluaranBarang->status == 'Level 4')
                                            Menunggu Persetujuan
                                        @elseif ($pengeluaranBarang->status == 'Level 5')
                                            Sudah Disetujui
                                        @else
                                            {{ $pengeluaranBarang->status }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($pengeluaranBarang->status == 'Level 4')
                                            <button type="button" class="btn btn-success btn-sm" onclick="editApproval('{{ $pengeluaranBarang->pengeluaran_barang_id }}', '{{ $pengeluaranBarang->tujuan_pengeluaran_barang }}', '{{ $pengeluaranBarang->jenis_kendaraan }}', '{{ $pengeluaranBarang->no_polisi }}')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @elseif ($pengeluaranBarang->status == 'Level 5')
                                        <button type="button" class="btn btn-primary btn-sm" onclick="editApproval('{{ $pengeluaranBarang->pengeluaran_barang_id }}', '{{ $pengeluaranBarang->tujuan_pengeluaran_barang }}', '{{ $pengeluaranBarang->jenis_kendaraan }}', '{{ $pengeluaranBarang->no_polisi }}')">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Approval -->
    <div class="modal fade" id="editApprovalModal" tabindex="-1" aria-labelledby="editApprovalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="editApprovalLabel">Edit Approval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editApprovalForm">
                        <div class="row mb-3">
                            <label for="pengeluaranBarangId" class="col-sm-4 col-form-label">No. Pengeluaran</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pengeluaranBarangId" name="pengeluaranBarangId" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tujuan" class="col-sm-4 col-form-label">Tujuan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="tujuan" name="tujuan" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="jenisKendaraan" class="col-sm-4 col-form-label">Jenis Kendaraan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="jenisKendaraan" name="jenisKendaraan" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="noPolisi" class="col-sm-4 col-form-label">No. Polisi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="noPolisi" name="noPolisi">
                            </div>
                        </div>
                    </form>
    
                    <h6 class="mt-4">Detail Barang</h6>
                    <table id="barangTable" class="table table-striped table-bordered">
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
                            <!-- Data akan diisi melalui JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-center">
                    @if ($pengeluaranBarang->status == 'Level 5')
                        <!-- Jika status adalah Level 5, tombol "Setujui" disembunyikan -->
                        <form action="{{ route('approval.updateStatusSecurity') }}" method="POST" id="approvalForm" style="display:none;">
                            @csrf
                            @method('POST')
                            <button type="button" class="btn btn-success" onclick="saveApproval()">Setujui</button>
                        </form>
                    @elseif ($pengeluaranBarang->status == 'Level 4')
                        <form action="{{ route('approval.updateStatusSecurity') }}" method="POST" id="approvalForm">
                            @csrf
                            @method('POST')
                            <button type="button" class="btn btn-success" onclick="saveApproval()">Setujui</button>
                        </form>
                    @endif                
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
               
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            columnDefs: [
                {className: 'dt-body-center', targets: 0},
                {className: 'dt-head-center', targets: 0},
                {className: 'dt-body-center', targets: 3},
                {className: 'dt-head-center', targets: 3}
            ],
            scrollX: false,
            responsive: true
        });
    });

    function editApproval(pengeluaranBarangId, tujuan, jenisKendaraan, noPolisi) {
        document.getElementById('pengeluaranBarangId').value = pengeluaranBarangId;
        document.getElementById('tujuan').value = tujuan;
        document.getElementById('jenisKendaraan').value = jenisKendaraan;
        document.getElementById('noPolisi').value = noPolisi;

        // Clear the modal's table body
        const tableBody = document.querySelector('#barangTable tbody');
        tableBody.innerHTML = '';

        // Cari data barang terkait pengeluaranBarangId
        const barangDetails = @json($barangDetails);  // Mendapatkan data barang ke dalam JavaScript
        const filteredBarang = barangDetails.filter(barang => barang.pengeluaran_barang_id === pengeluaranBarangId);  // Filter barang berdasarkan pengeluaranBarangId

        // Isi tabel barang di modal
        filteredBarang.forEach((barang, index) => {
            const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${barang.nama_barang}</td>
                    <td>${barang.jumlah_barang}</td>
                    <td>${barang.satuan_barang}</td>
                    <td>${barang.keterangan_barang}</td>
                </tr>`;
            tableBody.innerHTML += row;
        });

        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById('editApprovalModal'));
        modal.show();
    }

    function saveApproval() {
        var pengeluaranBarangId = document.getElementById('pengeluaranBarangId').value;
        var noPolisi = document.getElementById('noPolisi').value;

        // Kirim data ke server menggunakan AJAX untuk memperbarui pengeluaran barang dan approval
        $.ajax({
            url: "{{ route('approval.updateStatusSecurity') }}",  // Ganti dengan route yang sesuai
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",  // CSRF token untuk keamanan
                pengeluaran_barang_id: pengeluaranBarangId,
                no_polisi: noPolisi
            },
            success: function(response) {
                if (response.success) {
                    // Tampilkan pesan sukses
                    alert(response.message);
                    // Tutup modal setelah sukses
                    $('#editApprovalModal').modal('hide');
                    // Refresh halaman atau update data sesuai kebutuhan
                    location.reload();  // Untuk me-refresh halaman setelah perubahan berhasil
                } else {
                    alert('Terjadi kesalahan: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    }
</script>  
