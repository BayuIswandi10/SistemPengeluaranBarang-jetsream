{{-- <style>
    iframe {
        width: 80mm;
        height: 80mm;
        border: none;
    }
</style> --}}

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
                                    <td >
                                        @if (in_array($pengeluaranBarang->status, ['Level 4', 'Level 5']))
                                            <button type="button" class="btn btn-{{ $pengeluaranBarang->status == 'Level 4' ? 'success' : 'primary' }} btn-sm" onclick="editApproval('{{ $pengeluaranBarang->pengeluaran_barang_id }}')">
                                                <i class="fas {{ $pengeluaranBarang->status == 'Level 4' ? 'fa-edit' : 'fa-info-circle' }}"></i>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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

                    <iframe hidden id="qrFrame" width="500" height="400" srcdoc="
                        <!DOCTYPE html>
                        <html lang='id'>
                        <head>
                            <meta charset='UTF-8'>
                            <style>
                                body { font-family: Arial, sans-serif; text-align: center; }
                                .container { width: 400px; border: 2px solid black; padding: 10px; margin: auto; }
                                .box { border: 1px solid black; padding: 10px; margin: 5px 0; }
                                .header { display: flex; justify-content: space-between; }
                                .header .box { width: 48%; }
                                .content { height: 100px; }
                                .footer { font-size: 12px; text-align: left; }
                            </style>
                        </head>
                        <body>
                            <div class='container'>
                                <div class='header'>
                                    <div class='box'><img src='{{ asset('assets/img/logo YMI-DLT.png') }}' style='height: 50px;'></div>
                                    <div class='box'>[QR CODE]</div>
                                </div>
                                <div class='box'><strong>SURAT PENGELUARAN BARANG</strong></div>
                                <div class='box'>[NO PENGELUARAN]</div>
                                <div class='box content'>[Barang Yang Keluar]</div>
                                <div class='footer'>
                                    MM 2100-Industrial Town Jl. Halmahera Block EE-1 Cikarang Barat, Bekasi 17520<br>
                                    Phone: +62 21 8980769; Fax: +62 21 8980770
                                </div>
                            </div>
                        </body>
                        </html>
                    ">
                        Browser Anda tidak mendukung iframe.
                    </iframe>
                    
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
                    <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="printIframe()">Cetak QR Code</button>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script>

    function printIframe() {
        var iframe = document.getElementById('qrFrame');
        iframe.contentWindow.print(); // Cetak isi dalam iframe
    }

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

    function editApproval(pengeluaranBarangId) {
        $.ajax({
            url: "{{ route('pengeluaran.edit') }}", // Pastikan route sudah benar
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                pengeluaran_barang_id: pengeluaranBarangId
            },
            success: function(response) {
                // Isi field pada modal
                $('#pengeluaranBarangId').val(response.pengeluaran_barang_id);
                $('#tujuan').val(response.tujuan_pengeluaran_barang);
                $('#jenisKendaraan').val(response.jenis_kendaraan);
                
                if(response.no_polisi !== null && response.no_polisi !== '') {
                    $('#noPolisi').val(response.no_polisi);
                    $('#noPolisi').prop('disabled', true);
                    // Disable tombol "Setujui" jika no_polisi sudah ada
                    $('#btnSaveApproval').prop('disabled', true);
                } else {
                    $('#noPolisi').val('');
                    $('#noPolisi').prop('disabled', false);
                    // Aktifkan tombol "Setujui" apabila belum ada no_polisi
                    $('#btnSaveApproval').prop('disabled', false);
                }

                // Jika status adalah Level 5, sembunyikan tombol "Setujui"
                if(response.status && response.status === 'Level 5') {
                    $('#btnSaveApproval').hide();
                } else {
                    $('#btnSaveApproval').show();
                }

                // Pastikan field selain noPolisi dalam keadaan disabled
                $('#pengeluaranBarangId, #tujuan, #jenisKendaraan').attr('disabled', true);
                $('#noPolisi').attr('disabled', false);

                // Isi tabel detail barang
                let tbody = $('#barangTable tbody');
                tbody.empty();
                if(response.barangKeluar && response.barangKeluar.length > 0) {
                    $.each(response.barangKeluar, function(index, barang) {
                        tbody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${barang.nama_barang}</td>
                                <td>${barang.jumlah_barang}</td>
                                <td>${barang.satuan_barang}</td>
                                <td>${barang.keterangan_barang}</td>
                            </tr>
                        `);
                    });
                } else {
                    tbody.append('<tr><td colspan="5" class="text-center">Tidak ada data barang</td></tr>');
                }

                // Update container QR Code dengan output dari BaconQrCode
                $('#qrcodeContainer').html(response.qr_code);

                // Perbarui isi srcdoc pada iframe dengan data terbaru
                let iframeContent = `
                    <!DOCTYPE html>
                    <html lang="id">
                    <head>
                        <meta charset="UTF-8">
                        <style>
                            body { font-family: Arial, sans-serif; text-align: center; }
                            .container { width: 400px; border: 2px solid black; padding: 10px; margin: auto; }
                            .box { border: 1px solid black; padding: 10px; margin: 5px 0; }
                            .header { display: flex; justify-content: space-between; }
                            .header .box { width: 48%; }
                            .content { height: 100px; }
                            .footer { font-size: 12px; text-align: left; }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="header">
                                <div class="box"><img src="{{ asset('assets/img/logo YMI-DLT.png') }}" style="height: 50px;"></div>
                                <div class="box">${response.qr_code}</div>
                            </div>
                            <div class="box"><strong>SURAT PENGELUARAN BARANG</strong></div>
                            <div class="box">${response.pengeluaran_barang_id}</div>
                            <div class="box content">[Barang Yang Keluar]</div>
                            <div class="footer">
                                MM 2100-Industrial Town Jl. Halmahera Block EE-1 Cikarang Barat, Bekasi 17520<br>
                                Phone: +62 21 8980769; Fax: +62 21 8980770
                            </div>
                        </div>
                    </body>
                    </html>
                `;
                $('#qrFrame').attr('srcdoc', iframeContent).prop('hidden', false);

                // Tampilkan modal menggunakan Bootstrap Modal
                var modal = new bootstrap.Modal(document.getElementById('editApprovalModal'));
                modal.show();
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: 'Tidak dapat mengambil data. Error: ' + error,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
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
            confirmButtonText: 'Ya, Setuju!',
            cancelButtonText: 'Batal',
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
