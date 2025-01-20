<div class ="content-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 mt-2 text-gray-800">Form Pengeluaran Barang</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                
            </div>
            <div class="card-body">
                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: '{{ session('success') }}',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    </script>
                @endif

                @if (session('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: '{{ session('error') }}',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    </script>
                @endif
                <table id="dataTable" class="table table-striped table-bordered nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nomor Pengeluaran Barang</th>
                            <th>Tujuan</th>
                            <th>Jenis Kendaraan</th>
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
                                    <td>{{ $pengeluaranBarang->tujuan_pengeluaran_barang }}</td>
                                    <td>{{ $pengeluaranBarang->jenis_kendaraan }}</td>
                                    <td>
                                        @if ($pengeluaranBarang->status == 'Level 4')
                                            Menunggu Persetujuan Security
                                        @elseif ($pengeluaranBarang->status == 'Level 5')
                                            Sudah Disetujui
                                        @elseif ($pengeluaranBarang->status == 'Level 1')
                                            Menunggu Persetujuan PIC/Ka.Sie
                                        @elseif ($pengeluaranBarang->status == 'Level 2')
                                            PIC/Ka.Sie Sudah Menyetujui
                                        @elseif ($pengeluaranBarang->status == 'Level 3')
                                            Menunggu Persetujuan Ka.Dept GA
                                        @else
                                            {{ $pengeluaranBarang->status }}
                                        @endif

                                    </td>
                                    <td>
                                        <div class="button-group d-flex">
                                        <!-- Button detail -->
                                            <button 
                                                type="button" 
                                                class="btn btn-info btn-sm mr-2" 
                                                data-toggle="modal" 
                                                data-target="#detailModal" 
                                                data-items="{{ json_encode($pengeluaranBarang->barangKeluar) }}" 
                                                data-nomor="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa fa-list"></i>
                                            </button>
                                                <!-- Button for Level 1 (Ka.Sie) -->
                                            @if($pengeluaranBarang->status === 'Level 1')
                                                <button 
                                                    type="button" 
                                                    class="btn btn-success btn-sm update-status-kasie" 
                                                    data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                    Ka.Sie Setujui
                                                </button>
                                            @endif

                                            <!-- Button for Level 2 (Ka.Dept YBS) -->
                                            @if($pengeluaranBarang->status === 'Level 2')
                                                <button 
                                                    type="button" 
                                                    class="btn btn-success btn-sm update-status-kadeptybs" 
                                                    data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                    Ka.Dept YBS Setujui
                                                </button>
                                            @endif

                                            <!-- Button for Level 3 (Ka.Dept GA) -->
                                            @if($pengeluaranBarang->status === 'Level 3')
                                                <button 
                                                    type="button" 
                                                    class="btn btn-success btn-sm update-status-kadeptga" 
                                                    data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                    Ka.Dept GA Setujui
                                                </button>
                                            @endif

                                        </div>

                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
        
    {{-- Detail Modal --}}
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Barang Keluar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Nomor Pengeluaran Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="detailBody">
                            <!-- Data akan diisi secara dinamis -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    
    {{-- Edit Modal --}}    


</div>


<script>

$(document).ready(function() {
    // Button for Ka.Sie approval
    $('.update-status-kasie').on('click', function() {
        var pengeluaranBarangId = $(this).data('id');
        confirmUpdate(pengeluaranBarangId, '/pengeluaran/update-status-kasie');
    });

    // Button for Ka.Dept YBS approval
    $('.update-status-kadeptybs').on('click', function() {
        var pengeluaranBarangId = $(this).data('id');
        confirmUpdate(pengeluaranBarangId, '/pengeluaran/update-status-kadeptybs');
    });

    // Button for Ka.Dept GA approval
    $('.update-status-kadeptga').on('click', function() {
        var pengeluaranBarangId = $(this).data('id');
        confirmUpdate(pengeluaranBarangId, '/pengeluaran/update-status-kadeptga');
    });

    // Common function to show confirmation and then update status
    function confirmUpdate(pengeluaranBarangId, url) {
        Swal.fire({
            title: 'Konfirmasi Persetujuan',
            text: 'Apakah Anda yakin ingin menyetujui data pengeluaran ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Setuju!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(pengeluaranBarangId, url);
            }
        });
    }

    // Common function to handle status update
    function updateStatus(pengeluaranBarangId, url) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    pengeluaran_barang_id: pengeluaranBarangId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Success alert using SweetAlert
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload(); // Reload the table after successful update
                        });
                    } else {
                        // Error alert using SweetAlert
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(response) {
                    // Handle any error response using SweetAlert
                    Swal.fire({
                        title: 'Error!',
                        text: response.responseJSON.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });


    document.addEventListener('DOMContentLoaded', () => {
        $('#detailModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget); // Button yang diklik
            const items = button.data('items'); // Data barang
            const nomor = button.data('nomor'); // Nomor pengeluaran barang

            // Kosongkan tabel modal
            const tbody = document.getElementById('detailBody');
            tbody.innerHTML = '';

            // Isi tabel modal dengan data
            items.forEach((item, index) => {
                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${nomor}</td>
                        <td>${item.nama_barang}</td>
                        <td>${item.jumlah_barang}</td>
                        <td>${item.satuan_barang}</td>
                        <td>${item.keterangan_barang}</td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        });
    });


    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            columnDefs: [
                {className: 'dt-body-center', targets: 0},
                {className: 'dt-head-center', targets: 0},
                {className: 'dt-body-center', targets: 5},
                {className: 'dt-head-center', targets: 5}
            ],
            scrollX: false,
            responsive: true
        });
    });

    let counter = 1;

    function tambahComboBox() {
        const container = document.getElementById('barangTable');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td class="nomor">${counter += 1}</td>
            <td><input type="text" name="barang_ids[]" class="form-control" placeholder="Nama Barang" required></td>
            <td><input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required></td>
            <td><input type="text" name="satuan[]" class="form-control" placeholder="Satuan" required></td>
            <td><input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan" required></td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBox(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;

        container.appendChild(newRow);
        updateNomor();
    }

    function hapusComboBox(button) {
        const container = document.getElementById('barangTable');
        const rows = container.getElementsByTagName('tr');
        if (rows.length > 1) {
            const row = button.closest('tr');
            
            // SweetAlert konfirmasi untuk baris selain baris terakhir
            Swal.fire({
                icon: 'warning',
                title: 'Apakah Anda yakin?',
                text: 'Baris ini akan dihapus.',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    row.remove();
                    updateNomor();
                }
            });
        } else {
            // Ganti alert dengan SweetAlert untuk baris terakhir
            Swal.fire({
                icon: 'info',
                title: 'Tidak bisa menghapus baris terakhir.',
                text: 'Harap tambahkan baris baru jika perlu.',
                confirmButtonText: 'OK'
            });
        }
    }
    function updateNomor() {
    const rows = document.querySelectorAll('#barangTable .nomor');
        rows.forEach((cell, index) => {
            cell.textContent = index + 1;
        });
    }

    // Display validation errors in Swal
    @if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Whoops!',
        html: '<ul>' +
            @foreach ($errors->all() as $error)
                '<li>{{ $error }}</li>' +
            @endforeach
            '</ul>'
    });
    @endif

    // Display success message in Swal
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}'
        });
    @endif

    // Display error message in Swal
    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}'
        });
    @endif

    var $select = $('#select-tools').selectize({
    
    create: true
    });

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

var control = $select[0].selectize;

$('#button-clear').on('click', function() {
  control.clear();
});

$('#button-clearoptions').on('click', function() {
  control.clearOptions();
});

$('#button-addoption').on('click', function() {
  control.addOption({
    id: 4,
    title: 'Something New',
    url: 'http://google.com'
  });
});

$('#button-additem').on('click', function() {
  control.addItem(2);
});

$('#button-maxitems2').on('click', function() {
  control.setMaxItems(2);
});

$('#button-maxitems100').on('click', function() {
  control.setMaxItems(100);
});

$('#button-setvalue').on('click', function() {
  control.setValue([2, 3]);
});
        
</script>