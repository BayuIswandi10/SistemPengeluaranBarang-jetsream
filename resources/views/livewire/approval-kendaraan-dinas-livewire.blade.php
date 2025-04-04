<div class ="content-wrapper">
    <div class="container-fluid">

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center" style="border-top: 5px solid #5A6ACF;">
                <h6 class="m-0 font-weight-bold text-primary">Data Persetujuan</h6>
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
                            <th>No Surat Pengajuan Kendaraan Dinas</th>
                            <th>Tujuan</th>
                            <th>Jenis Mobil</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach ($kendaraanDinas as $dataKD)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $dataKD->surat_kendaraan_dinas_id }}</td>
                                <td>{{ $dataKD->tujuan_penggunaan_1 }}</td>
                                <td>
                                    @if ($dataKD->jenis_kendaraan == 1)
                                        Mobil Dinas
                                    @elseif ($dataKD->jenis_kendaraan == 2)
                                        Mobil Pribadi
                                    @elseif ($dataKD->jenis_kendaraan == 3)
                                        Mobil Taxi
                                    @endif
                                </td>
                                <td>
                                    @if ($dataKD->status == 'Level 1')
                                        Menunggu Persetujuan Ka.Dept
                                    @elseif ($dataKD->status == 'Level 2')
                                        Menunggu Persetujuan Ka.Sie Transportasi
                                    @elseif ($dataKD->status == 'Level 3')
                                        Sudah Disetujui
                                    @elseif ($dataKD->status == 'Level 0')
                                        Ditolak
                                    @else
                                        {{ $dataKD->status }}
                                    @endif
                                </td>
                                <td>
                                    <div class="button-group d-flex">

                
                                        <!-- Button for Level 1 (Ka.Dept YBS) -->
                                        @if($dataKD->status === 'Level 1' && $user->level === 'Ka.Dept' && $user->departemen !== 'General Affairs')
                                            <button 
                                                type="button" 
                                                class="btn btn-success btn-sm mr-2 update-status-kadeptybs" 
                                                data-id="{{ $dataKD->surat_kendaraan_dinas_id }}">
                                                <i class="fa-solid fa-paper-plane"></i>
                                            </button>

                                            <!-- Button reject -->
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm mr-2 reject-status" 
                                                data-id="{{ $dataKD->surat_kendaraan_dinas_id }}">
                                                <i class="fa-solid fa-times-circle"></i>
                                            </button>

                                        @endif
                
                                        <!-- Button for Level 2 (Ka.Dept GA) -->
                                        @if($dataKD->status === 'Level 2' && $user->level === 'Ka.Sie' && $user->departemen == 'General Affairs')
                                            <button 
                                                type="button" 
                                                class="btn btn-success btn-sm mr-2 update-status-kasietransportasi" 
                                                data-id="{{ $dataKD->surat_kendaraan_dinas_id }}">
                                                <i class="fa-solid fa-paper-plane"></i>
                                            </button>

                                            <!-- Button Edit -->
                                            <button 
                                                type="button" 
                                                class="btn btn-warning btn-sm mr-2" 
                                                data-toggle="modal" 
                                                data-target="#editDataModal" 
                                                data-id="{{ $dataKD->surat_kendaraan_dinas_id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Button reject -->
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm mr-2 reject-status" 
                                                data-id="{{ $dataKD->surat_kendaraan_dinas_id }}">
                                                <i class="fa-solid fa-times-circle"></i>
                                            </button>
                                        @endif                                        

                                        <!-- Button detail -->
                                        <button 
                                            type="button" 
                                            class="btn btn-primary btn-sm mr-2" 
                                            data-toggle="modal" 
                                            data-target="#detailModal" 
                                            data-nomor="{{ $dataKD->surat_kendaraan_dinas_id }}">
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
                    <h5 class="modal-title" id="detailModalLabel">Detail Surat Dinas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <p><strong>Nomor Surat:</strong> <span id="nomorSuratCard"></span></p>
                    </div>
                    <!-- Card untuk Tabel Informasi Kendaraan -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">Informasi Kendaraan</h6>
                        </div>
                        <div class="card-body">
                            <table id="kendaraanInfoTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Kendaraan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="kendaraanInfoBody">
                                    <!-- Data akan diisi secara dinamis -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Card untuk Tabel Barang Keluar -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Informasi Peserta</h6>
                        </div>
                        <div class="card-body">
                            <table id="detaildataTableModal" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nrp Peserta</th>
                                        <th>Nama Peserta</th>
                                        <th>Departemen</th>
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
                            <h6 class="mb-0">Informasi Historis Persetujuan</h6>
                        </div>
                        <div class="card-body">
                            <table id="additionalInfoTable" class="table table-bordered">
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

    <!-- Modal Edit Order Kendaraan Dinas -->
    <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Edit Order Kendaraan Dinas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Informasi Nomor Surat -->
                    <div class="d-flex justify-content-between align-items-center">
                        <p><strong>Nomor Surat:</strong> <span id="nomorSurat"></span></p>
                    </div>

                    <!-- Form Edit -->
                    <form id="editOrderForm" method="POST" action="" enctype="multipart/form-data" >
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Yang Memesan -->
                                <label for="pemesan">Yang Memesan *</label>
                                <input type="text" id="pemesan" class="form-control" disabled>

                                <!-- Rencana Pakai -->
                                <label for="jamMulai" class="mt-2">Rencana Pakai *</label>
                                <div class="d-flex">
                                    <input type="time" id="jamMulai" class="form-control mr-2">
                                    <input type="time" id="jamSelesai" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Kendaraan Info -->
                                <label for="kendaraan" class="mt-2">Kendaraan *</label>
                                <div class="border p-2 table-responsive">
                                    <table id="kendaraanInfo" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID Kendaraan</th>
                                                <th>No Kendaraan</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="kendaraanInfo"></tbody>
                                    </table>
                                    <button type="button" class="btn btn-success btn-sm" id="addKendaraan">+ Kendaraan Dinas</button>
                                </div>
                            </div>
                        </div>


                        <label class="mt-3">Tujuan *</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" id="tujuan_1" class="form-control" placeholder="Tujuan 1">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="tujuan_2" class="form-control" placeholder="Tujuan 2">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="tujuan_3" class="form-control" placeholder="Tujuan 3">
                            </div>
                        </div>


                        <!-- Jenis Mobil -->
                        <label for="jenisMobil" class="mt-2">Jenis Mobil *</label>
                        <input type="text" id="jenisMobil" class="form-control">

                        <!-- Digunakan Pada -->
                        <label for="tanggalPakai" class="mt-2">Digunakan Pada *</label>
                        <input type="date" id="tanggalPakai" class="form-control">

                        <!-- Tabel Peserta -->
                        <label class="mt-3">Peserta *</label>
                        <table id="pesertaList" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NRP</th>
                                    <th>Nama Karyawan</th>
                                    <th>Divisi Departemen</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody id="pesertaList"></tbody>
                        </table>

                        <!-- Tombol Pindahkan Peserta & Simpan -->
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-success" id="pindahkanPeserta">Pindahkan Peserta</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


        
</div>


<script>

    $('#editDataModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); 
        const dataKD = button.data('id'); 


        $('#nomorSurat').val('');
        $('#pemesan').val('');
        $('#jenisMobil').val('');
        $('#tanggalPakai').val('');
        $('#jamMulai').val('');
        $('#jamSelesai').val('');

        
        $.ajax({
            url: "/pengajuan/edit", // Sesuaikan dengan route Laravel
            type: "POST",
            data: { surat_kendaraan_dinas_id: dataKD,
                "_token": "{{ csrf_token() }}"  // CSRF token
             },
            dataType: "json",
            success: function (response) {
                if (response) {
                    // Set data ke modal
                    $("#nomorSurat").text(response.surat_kendaraan_dinas_id);
                    $("#pemesan").val(response.userDinas[0].nrp_karyawan || "Tidak Diketahui");
                    $("#jenisMobil").val(response.jenis_kendaraan);
                    $("#tanggalPakai").val(response.tanggal_penggunaan);
                    $("#jamMulai").val(response.waktu_keluar);
                    $("#jamSelesai").val(response.waktu_kembali);
                    $("#tujuan_1").val(response.tujuan_penggunaan_1);
                    $("#tujuan_2").val(response.tujuan_penggunaan_2);
                    $("#tujuan_3").val(response.tujuan_penggunaan_3);

                    // Kosongkan dan isi ulang data kendaraan
                    $("#kendaraanInfo").empty();
                    response.data_kendaraan.forEach(function (kendaraan) {
                        $("#kendaraanInfo").append(`
                            <tr>
                                <td>${kendaraan.id_kendaraan}</td>
                                <td>${kendaraan.nomor_kendaraan}</td>
                                <td>${kendaraan.keterangan}</td>
                            </tr>
                        `);
                    });

                    // Kosongkan dan isi ulang data peserta
                    $("#pesertaList").empty();
                    response.userDinas.forEach(function (user, index) {
                        $("#pesertaList").append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${user.nrp_karyawan}</td>
                                <td>${user.name}</td>
                                <td>${user.departemen}</td>
                                <td><input type="checkbox" class="pilihPeserta"></td>
                            </tr>
                        `);
                    });

                    // Tampilkan modal edit
                    $("#editDataModal").modal("show");
                }
            },
            error: function () {
                alert("Gagal mengambil data. Coba lagi.");
            },
        });
    });

$(document).ready(function() {


    // Button for Ka.Dept YBS approval
    $('.update-status-kadeptybs').on('click', function() {
        var dataKDId = $(this).data('id');
        confirmUpdate(dataKDId, '/pengajuanDinas/update-status-kadeptybs');
    });

    // Button for Ka.Sie Transport GA approval
    $('.update-status-kasietransportasi').on('click', function() {
        var dataKDId = $(this).data('id');
        confirmUpdate(dataKDId, '/pengajuanDinas/update-status-kasietransportasi');
    });

    // Common function to show confirmation and then update status
    function confirmUpdate(dataKDId, url) {
        Swal.fire({
            title: 'Konfirmasi Persetujuan',
            text: 'Apakah anda menyetujui No Surat Dinas ' + dataKDId + '?',
            icon: 'info',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Setuju!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(dataKDId, url);
            }
        });
    }

    // Common function to handle status update
    function updateStatus(dataKDId, url) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    surat_kendaraan_dinas_id: dataKDId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Success alert using SweetAlert
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Surat Dinas dengan No: ' + dataKDId + ' telah disetujui.',
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
            document.getElementById('nomorSuratCard').innerText = nomor;

            $.ajax({
                url: "/pengajuan/detailSurat",
                method: "POST",
                data: { surat_kendaraan_dinas_id: nomor, "_token": "{{ csrf_token() }}" },
                success: function (data) {
                    const detailTable = $('#detaildataTableModal').DataTable();

                    const jenisKendraan = {
                        1 : "Mengeluarkan"
                    };

                    // Kosongkan data lama kendaraan
                    document.getElementById('kendaraanInfoBody').innerHTML = "";

                    // Validasi dan tampilkan data kendaraan
                    if (data.data_kendaraan && data.data_kendaraan.length > 0) {
                        data.data_kendaraan.forEach((item, index) => {
                            let row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.nomor_kendaraan}</td>
                                    <td>${item.keterangan}</td>
                                </tr>
                            `;
                            document.getElementById('kendaraanInfoBody').innerHTML += row;
                        });
                    } else {
                        document.getElementById('kendaraanInfoBody').innerHTML = `
                            <tr><td colspan="4" class="text-center">Tidak ada data kendaraan</td></tr>
                        `;
                    }

                    // Kosongkan data lama
                    detailTable.clear();
                    document.getElementById('additionalInfoBody').innerHTML = ""; // Kosongkan tabel Informasi Tambahan

                    // Validasi data userDinas
                    if (data.userDinas && data.userDinas.length > 0) {
                        let newData = data.userDinas.map((item, index) => [
                            index + 1,
                            item.nrp_karyawan,
                            item.name,
                            item.departemen
                        ]);
                        detailTable.rows.add(newData).draw();
                    } else {
                        detailTable.rows.add([["", "", "Tidak ada data user", "", "", ""]]).draw();
                    }

                    // Mapping tingkatan dan status persetujuan
                    const tingkatMapping = {
                        "Level 1": "Civitas",
                        "Level 2": "PIC/Ka.Sie",
                        "Level 3": "Ka.Dept.Ybs",
                        "Level 4": "Ka.Dept.GA",
                        "Level 5": "Finance",
                        "Level 6": "Security"
                    };
                    const approvMapping = {
                        "Level 0": "Menolak",
                        "Level 1": "Mengeluarkan",
                        "Level 2": "Membawa",
                        "Level 3": "Menyetujui",
                        "Level 4": "Mengetahui",
                        "Level 5": "Menerima",
                        "Level 6": "Memeriksa"
                    };

                    // Validasi data informasi_tambahan
                    const additionalInfoBody = document.getElementById('additionalInfoBody');

                    if (data.informasi_tambahan && data.informasi_tambahan.length > 0) {
                        data.informasi_tambahan.forEach((info, index) => {
                            let row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${info.nama}</td>
                                    <td>${tingkatMapping[info.tingkatan] || info.tingkatan}</td>
                                    <td>${info.departemen}</td>
                                    <td>${approvMapping[info.status] || info.status}</td>
                                </tr>
                            `;
                            additionalInfoBody.innerHTML += row;
                        });
                    } else {
                        additionalInfoBody.innerHTML = `
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada informasi tambahan</td>
                            </tr>
                        `;
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

        // Inisialisasi DataTable hanya untuk tabel barang keluar
        if (!$.fn.DataTable.isDataTable('#detaildataTableModal')) {
            $('#detaildataTableModal').DataTable({
                responsive: true,
                autoWidth: false,
                scrollX: false,
                destroy: true,
                retrieve: true,
                pageLength: 5, // Menentukan jumlah default entries per page menjadi 5
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]] 
            });
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
        $('.select-tools').selectize({
            create: true, // Memungkinkan pengguna menambahkan opsi baru
            sortField: 'text' // Mengurutkan opsi berdasarkan teks
        });

        // Handle click event on update status button
        document.querySelectorAll('.reject-status').forEach(button => {
            button.addEventListener('click', function () {
                const dataKDId = this.getAttribute('data-id');

                // Konfirmasi menggunakan SweetAlert
                Swal.fire({
                    title: 'Tolak Pengajuan',
                    text: 'Apakah anda menolak No Surat Dinas ' + dataKDId + '?',
                    icon: 'error',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('pengajuanDinas.rejectStatus') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ surat_kendaraan_dinas_id: dataKDId })
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


    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable({
                columnDefs: [
                    { className: 'dt-body-center', targets: 0 },
                    { className: 'dt-head-center', targets: 0 },
                    { className: 'dt-body-center', targets: 5 },
                    { className: 'dt-head-center', targets: 5 }
                ],
                scrollX: false,
                responsive: true
            });
        }
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