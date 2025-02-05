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
                                    @if ($pengeluaranBarang->status == 'Level 1')
                                        Menunggu Persetujuan PIC/Ka.Sie
                                    @elseif ($pengeluaranBarang->status == 'Level 2')
                                        PIC/Ka.Sie Sudah Menyetujui
                                    @elseif ($pengeluaranBarang->status == 'Level 3')
                                        Menunggu Persetujuan Ka.Dept GA
                                    @elseif ($pengeluaranBarang->status == 'Level 4')
                                        Menunggu Persetujuan Security
                                    @elseif ($pengeluaranBarang->status == 'Level 5')
                                        Sudah Disetujui
                                    @else
                                        {{ $pengeluaranBarang->status }}
                                    @endif
                                </td>
                                <td>
                                    <div class="button-group d-flex">
                                        <!-- Button for Level 1 (Ka.Sie) -->
                                        @if($pengeluaranBarang->status === 'Level 1' && $user->level === 'Level 2')
                                            
                                            <button 
                                                type="button" 
                                                class="btn btn-success btn-sm mr-2 update-status-kasie" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-paper-plane"></i>
                                            </button>

                                            <!-- Button reject -->
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm mr-2 reject-status" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-times-circle"></i>
                                            </button>
                                        @endif
                
                                        <!-- Button for Level 2 (Ka.Dept YBS) -->
                                        @if($pengeluaranBarang->status === 'Level 2' && $user->level === 'Level 3')
                                            <button 
                                                type="button" 
                                                class="btn btn-success btn-sm mr-2 update-status-kadeptybs" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-paper-plane"></i>
                                            </button>

                                            <!-- Button reject -->
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm mr-2 reject-status" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-times-circle"></i>
                                            </button>

                                        @endif
                
                                        <!-- Button for Level 3 (Ka.Dept GA) -->
                                        @if($pengeluaranBarang->status === 'Level 3' && $user->level === 'Level 4')
                                            <button 
                                                type="button" 
                                                class="btn btn-success btn-sm mr-2 update-status-kadeptga" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-paper-plane"></i>
                                            </button>

                                            <!-- Button reject -->
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm mr-2 reject-status" 
                                                data-id="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                                <i class="fa-solid fa-times-circle"></i>
                                            </button>
                                        @endif

                                        <!-- Button detail -->
                                        <button 
                                            type="button" 
                                            class="btn btn-primary btn-sm mr-2" 
                                            data-toggle="modal" 
                                            data-target="#detailModal" 
                                            data-nomor="{{ $pengeluaranBarang->pengeluaran_barang_id }}">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </button>

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
                    <p><strong>Nomor Pengeluaran:</strong> <span id="nomorPengeluaranCard"></span></p>
                    <!-- Card untuk Tabel Barang Keluar -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Detail Barang Keluar</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
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

                    <hr>

                    <!-- Card untuk Tabel Informasi Tambahan -->
                    <div class="card mt-4">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">Informasi Tambahan</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tingkatan</th>
                                        <th>Departemen</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="additionalInfoBody">
                                    <!-- Data akan diisi secara dinamis -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



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
            icon: 'info',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Setuju!',
            cancelButtonText: 'Batal'
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
            const nomor = button.data('nomor'); // Nomor pengeluaran barang
            document.getElementById('nomorPengeluaranCard').innerText = nomor;

            $.ajax({
                url: "/pengeluaran/detail",
                method: "POST",
                data: { pengeluaran_barang_id: nomor, "_token": "{{ csrf_token() }}" },
                success: function (data) {
                    // console.log("Response dari server:", data); // Debugging

                    const tbody = document.getElementById('detailBody');
                    const additionalInfoBody = document.getElementById('additionalInfoBody');

                    tbody.innerHTML = '';
                    additionalInfoBody.innerHTML = '';

                    // Validasi data barang_keluar
                    if (data.barang_keluar && data.barang_keluar.length > 0) {
                        tbody.innerHTML = data.barang_keluar.map((item, index) => `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${nomor}</td>
                                <td>${item.nama_barang}</td>
                                <td>${item.jumlah_barang}</td>
                                <td>${item.satuan_barang}</td>
                                <td>${item.keterangan_barang}</td>
                            </tr>
                        `).join('');
                    } else {
                        tbody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data barang keluar</td></tr>';
                    }

                    const tingkatMapping = {
                        "Level 1": "Civitas",
                        "Level 2": "PIC/Ka.Sie",
                        "Level 3": "Ka.Dept.Ybs",
                        "Level 4": "Ka.Dept.GA",
                        "Level 5": "Security"
                    };

                    const approvMapping = {
                        "Level 1": "Mengeluarkan",
                        "Level 2": "Membawa",
                        "Level 3": "Menyetujui",
                        "Level 4": "Mengetahui",
                        "Level 5": "Memeriksa"
                    };


                    // Validasi data informasi_tambahan
                    if (data.informasi_tambahan && data.informasi_tambahan.length > 0) {
                        additionalInfoBody.innerHTML = data.informasi_tambahan.map((info, index) => `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${info.nama}</td>
                                <td>${tingkatMapping[info.tingkatan] || info.tingkatan}</td>
                                <td>${info.departemen}</td>
                                <td>${approvMapping[info.status] || info.status}</td>
                            </tr>
                        `).join('');
                    } else {
                        additionalInfoBody.innerHTML = '<tr><td colspan="5" class="text-center">Tidak ada informasi tambahan</td></tr>';
                    }

                    // Pastikan modal terbuka setelah data dimuat
                    $('#detailModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data:", error);
                    alert("Terjadi kesalahan saat mengambil data.");
                }
            });
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
        $('.select-tools').selectize({
            create: true, // Memungkinkan pengguna menambahkan opsi baru
            sortField: 'text' // Mengurutkan opsi berdasarkan teks
        });

        // Handle click event on update status button
        document.querySelectorAll('.reject-status').forEach(button => {
            button.addEventListener('click', function () {
                const pengeluaranBarangId = this.getAttribute('data-id');

                // Konfirmasi menggunakan SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan Menolak pengajuan pengeluaran barang!",
                    icon: 'info',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('approval.rejectStatus') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ pengeluaran_barang_id: pengeluaranBarangId })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Tampilkan notifikasi berhasil
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload(); // Reload halaman untuk merefleksikan perubahan
                                });
                            } else {
                                // Tampilkan notifikasi error
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            // Tampilkan notifikasi error jika terjadi kesalahan
                            Swal.fire({
                                title: 'Terjadi Kesalahan!',
                                text: 'Error: ' + error.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                    }
                });
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