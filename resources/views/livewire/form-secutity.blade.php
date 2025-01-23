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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="editApprovalLabel">Edit Approval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editApprovalForm">
                        <div class="row mb-3">
                            <div class="col-md-8">
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
                            </div>
                            <div class="col-md-4 text-end">
                                <div id="qrcodeContainer" style="border: 1px solid #ddd; padding: 10px; text-align: center;">
                                    <!-- QR Code akan diisi oleh JavaScript -->
                                    <img src="path/to/qrcode.png" alt="QR Code" id="qrcode" style="width: 100%;">
                                </div>
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
                    <form action="{{ route('approval.updateStatusSecurity') }}" method="POST" id="approvalForm">
                        @csrf
                        @method('POST')
                        <button type="button" class="btn btn-success" onclick="saveApproval()">Setujui</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="printQRCode()">Cetak QR Code</button>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script>

    function printQRCode() {
        var originalContent = document.body.innerHTML;
        var qrCodeContent = document.getElementById("qrcodeContainer").innerHTML;

        // Tampilkan hanya QR Code
        document.body.innerHTML = qrCodeContent;

        window.print();

        // Kembalikan tampilan asli setelah pencetakan
        document.body.innerHTML = originalContent;
    }

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


        // Tampilkan QR Code
        const qrCodeContainer = document.getElementById('qrcodeContainer');
        qrCodeContainer.innerHTML = '';
        const qrCodes = @json($qrCodes);
        qrCodeContainer.innerHTML = qrCodes[pengeluaranBarangId] || '<p>QR Code tidak tersedia.</p>';

        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById('editApprovalModal'));
        modal.show();
    }


    function saveApproval() {
        var pengeluaranBarangId = document.getElementById('pengeluaranBarangId').value;
        var noPolisi = document.getElementById('noPolisi').value;

        // Konfirmasi dengan Swal sebelum melakukan update
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Setujui pengeluaran ini?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, Setuju!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
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
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                // Reload halaman setelah sukses
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            text: 'Error: ' + error,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            }
        });
    }

</script>  
