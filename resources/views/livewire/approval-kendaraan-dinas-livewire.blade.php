<div class ="content-wrapper">
    <style>
        /* Pastikan modal tidak lebih besar dari layar */
        @media (max-width: 768px) {
            .modal-dialog {
                max-width: 95%;
                margin: 1.75rem auto;
            }
        }

        /* Pastikan isi modal bisa di-scroll jika terlalu panjang */
        .modal-body {
            overflow-x: auto;
        }
    </style>
    <div class="container-fluid">

        <div class="card mt-3">
           <div class="card-header" style="border-top: 5px solid #5A6ACF; display: flex; align-items: center; padding: 0.75rem 1.25rem;">
            <h6 class="m-0 font-weight-bold text-primary" style="flex-grow: 1;">Data Persetujuan</h6>
                
            <div class="col-md-4 col-12">
                <div class="input-group">
                    <input type="text" id="date-range-picker" class="form-control" placeholder="Pilih Rentang Tanggal">
                </div>
            </div>

            <a href="{{ route('data-kendaraan-dinas.export') }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-export me-1"></i> Export Excel
            </a>
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
                                <td>
                                    {{ $dataKD->tujuan_penggunaan_1 ?? '-' }} > {{ $dataKD->tujuan_penggunaan_2 ?? '-' }}
                                    > {{ $dataKD->tujuan_penggunaan_3 ?? '-' }}
                                </td>
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
                                        Menunggu Persetujuan Security 
                                    @elseif ($dataKD->status == 'Level 4')
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
                                            @if ($dataKD->jenis_kendaraan == 1)
                                                <button 
                                                    type="button" 
                                                    class="btn btn-warning btn-sm mr-2" 
                                                    data-toggle="modal" 
                                                    data-target="#editDataModal" 
                                                    data-id="{{ $dataKD->surat_kendaraan_dinas_id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif

                                            <!-- Button reject -->
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm mr-2 reject-status" 
                                                data-id="{{ $dataKD->surat_kendaraan_dinas_id }}">
                                                <i class="fa-solid fa-times-circle"></i>
                                            </button>
                                        @endif                                        

                                        @if($dataKD->status === 'Level 2' && $user->level === 'Super Admin' && $user->departemen == 'General Affairs')
                                            <button 
                                                type="button" 
                                                class="btn btn-success btn-sm mr-2 update-status-kasietransportasi" 
                                                data-id="{{ $dataKD->surat_kendaraan_dinas_id }}">
                                                <i class="fa-solid fa-paper-plane"></i>
                                            </button>

                                            <!-- Button Edit -->
                                            @if ($dataKD->jenis_kendaraan == 1)
                                                <button 
                                                    type="button" 
                                                    class="btn btn-warning btn-sm mr-2" 
                                                    data-toggle="modal" 
                                                    data-target="#editDataModal" 
                                                    data-id="{{ $dataKD->surat_kendaraan_dinas_id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif

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
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
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
    <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
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
                    <form id="editOrderForm" method="POST" action="{{route('pengajuan.update')}}" enctype="multipart/form-data" >
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Yang Memesan -->
                                <label for="pemesan">Yang Memesan *</label>
                                <input type="hidden" name="surat_kendaraan_dinas_id" id="surat_kendaraan_dinas_id">
                                <input type="text" name="nrp_karyawan" id="pemesan" class="form-control" disabled>
                            </div>

                            <div class="col-md-12 mt-3">
                                <!-- Kendaraan Info -->
                                <label for="kendaraan" class="mt-2">Kendaraan *</label>
                                <div class="border p-2 table-responsive">
                                    <table id="kendaraanInfo" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Kendaraan</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-success btn-sm" onclick="tambahComboBoxEdit()">
                                        <i class="fas fa-plus"></i> Tambah Kendaraan
                                    </button>
                                </div>
                            </div>
                        </div>


                        <label class="mt-3">Tujuan *</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="tujuan_penggunaan_1" id="tujuan_1" class="form-control" placeholder="Tujuan 1">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="tujuan_penggunaan_2" id="tujuan_2" class="form-control" placeholder="Tujuan 2">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="tujuan_penggunaan_3" id="tujuan_3" class="form-control" placeholder="Tujuan 3">
                            </div>
                        </div>


                        <!-- Jenis Mobil -->
                        <label for="jenisMobil" class="mt-2">Jenis Mobil *</label>
                        <input type="text" name="jenis_kendaraan" id="jenisMobil" class="form-control">

                        <!-- Digunakan Pada -->
                        <label for="tanggalPakai" class="mt-2">Digunakan Pada *</label>
                        <input type="date" name="tanggal_penggunaan" id="tanggalPakai" class="form-control">

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
                            <tbody>

                            </tbody>
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

    <!-- Modal Pindah Peserta -->
    <div class="modal fade" id="modalPindahPeserta" tabindex="-1" aria-labelledby="staticBackdropModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pindah Ke Surat Persetujuan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="nrpPesertaDipindah" />
                
                    <!-- Tabel Peserta yang Dipindahkan -->
                    <h6><strong>Karyawan Yang Dipindahkan</strong></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabelPesertaDipindah">
                            <thead>
                                <tr>
                                    <th>NRP</th>
                                    <th>Nama Karyawan</th>
                                    <th>Nama Departemen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data via jQuery -->
                            </tbody>
                        </table>
                    </div>
                
                    <!-- Tabel Tujuan Dipindahkan -->
                    <h6 class="mt-4"><strong>Tujuan dipindahkan</strong></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabelTujuanSurat">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Surat</th>
                                    <th>Tujuan</th>
                                    <th>Jenis Mobil</th>
                                    <th>Status</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data via jQuery -->
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnSimpanPindah">Pindah</button>
                </div>
            </div>
        </div>
    </div>
  

        
</div>


<script>

    let pesertaDipindahkan = [];

    $('#pindahkanPeserta').click(function () {
        pesertaDipindahkan = [];
        $('#pesertaList input[type="checkbox"]:checked').each(function () {
            pesertaDipindahkan.push($(this).val());
        });

        if (pesertaDipindahkan.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak ada peserta dipilih',
                text: 'Silakan pilih peserta yang ingin dipindahkan.',
            });
            return;
        }

        const tanggal = $('#tanggalPakai').val();
        const currentSuratId = $('#surat_kendaraan_dinas_id').val();

        $.ajax({
            url: "/pengajuan/surat-tujuan",
            type: "GET",
            data: {
                tanggal_penggunaan: tanggal,
                current_surat_id: currentSuratId
            },
            success: function (data) {
                const pesertaList = [];
                $('#pesertaList input[type="checkbox"]:checked').each(function () {
                    const row = $(this).closest('tr');
                    const nrp = row.find('td:eq(1)').text();
                    const nama = row.find('td:eq(2)').text();
                    const dept = row.find('td:eq(3)').text();
                    pesertaList.push({ nrp, nama, dept });
                });

                const tbodyPeserta = $("#tabelPesertaDipindah tbody");
                tbodyPeserta.empty();
                pesertaList.forEach(p => {
                    tbodyPeserta.append(`
                        <tr>
                            <td>${p.nrp}</td>
                            <td>${p.nama}</td>
                            <td>${p.dept}</td>
                        </tr>
                    `);
                });

                let tbody = $("#tabelTujuanSurat tbody");
                tbody.empty();

                data.forEach((item, index) => {
                    tbody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.surat_kendaraan_dinas_id}</td>
                            <td>${item.tujuan_penggunaan_1}</td>
                            <td>${item.jenis_kendaraan}</td>
                            <td>${item.status}</td>
                            <td>
                                <input type="radio" name="surat_tujuan" value="${item.surat_kendaraan_dinas_id}">
                            </td>
                        </tr>
                    `);
                });

                $('#modalPindahPeserta').modal('show');
            }
        });
    });

     // Local Storage Retrive
     const savedRange = localStorage.getItem("selectedDateRange");
    if (savedRange) {
        const { start, end } = JSON.parse(savedRange);

        flatpickr("#date-range-picker", {
            mode: "range",
            dateFormat: "Y-m-d",
            locale: "id",
            defaultDate: [start, end],
            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const startDate = selectedDates[0].toISOString().split('T')[0];
                    const endDate = selectedDates[1].toISOString().split('T')[0];

                    // Simpan ke localStorage
                    localStorage.setItem("selectedDateRange", JSON.stringify({
                        start: startDate,
                        end: endDate
                    }));

                    // Panggil fungsi untuk memuat data
                    loadCounts(startDate, endDate);
                }
            },
        });

    } else {
        // Inisialisasi Flatpickr biasa jika belum ada data tersimpan
        flatpickr("#date-range-picker", {
            mode: "range",
            dateFormat: "Y-m-d",
            locale: "id",
            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const startDate = selectedDates[0].toISOString().split('T')[0];
                    const endDate = selectedDates[1].toISOString().split('T')[0];

                    localStorage.setItem("selectedDateRange", JSON.stringify({
                        start: startDate,
                        end: endDate
                    }));

                }
            },
        });
    }

    // Inisialisasi Flatpickr dengan event onChange untuk memuat count data
    flatpickr("#date-range-picker", {
        mode: "range", // Mode range date picker
        dateFormat: "Y-m-d", // Format tanggal
        locale: "id", // Opsional: Locale Indonesia
        onChange: function (selectedDates, dateStr, instance) {
            // Hanya jalankan jika kedua tanggal (range) sudah dipilih
            if (selectedDates.length === 2) {
                const startDate = selectedDates[0].toISOString().split('T')[0]; // Format start date ke YYYY-MM-DD
                const endDate = selectedDates[1].toISOString().split('T')[0];   // Format end date ke YYYY-MM-DD

                console.log("Start Date:", startDate); // Debug tanggal mulai
                console.log("End Date:", endDate);   // Debug tanggal akhir
            }
        },
    });

    // SIMPAN PINDAH
    $('#btnSimpanPindah').click(function () {
        const suratTujuan = $('input[name="surat_tujuan"]:checked').val();
        if (!suratTujuan) {
            Swal.fire({
                icon: 'warning',
                title: 'Surat tujuan belum dipilih',
                text: 'Silakan pilih salah satu surat tujuan terlebih dahulu.',
            });
            return;
        }

        $.ajax({
            url: '/pengajuan/pindahkan-peserta',
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                peserta: pesertaDipindahkan,
                surat_tujuan: suratTujuan
            },
            success: function () {
                let pesan = pesertaDipindahkan.map(nrp => `• Peserta dengan NRP ${nrp} berhasil dipindahkan ke surat dinas ${suratTujuan}.`).join('<br>');

                Swal.fire({
                    icon: 'success',
                    title: 'Pemindahan Berhasil',
                    html: pesan,
                    confirmButtonText: 'Tutup'
                }).then(() => {
                    location.reload();
                });
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat memindahkan peserta. Silakan coba lagi.',
                });
            }
        });
    });


    $('#editDataModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); 
        const dataKD = button.data('id'); 


        $('#nomorSurat').text('');
        $('#pemesan').val('');
        $('#jenisMobil').val('');
        $('#tanggalPakai').val('');
        $('#jamMulai').val('');
        $('#jamSelesai').val('');
        $('#kendaraanInfo tbody').empty();
        $('#pesertaList tbody').empty();

        
        $.ajax({
            url: "/pengajuan/edit", // Sesuaikan dengan route Laravel
            type: "POST",
            data: { surat_kendaraan_dinas_id: dataKD,
                "_token": "{{ csrf_token() }}"  // CSRF token
             },
            dataType: "json",
            success: function (response) {
                if (response) {
                    window.daftarKendaraanGlobal = response.daftar_kendaraan;

                    $("#surat_kendaraan_dinas_id").val(response.surat_kendaraan_dinas_id);
                    $("#pemesan").val(response.userDinas[0]?.nrp_karyawan || ''); // asumsi hanya satu pemesan
                    $("#jenisMobil").val(response.jenis_kendaraan);
                    $("#tanggalPakai").val(response.tanggal_penggunaan);
                    $("#jamMulai").val(response.waktu_keluar);
                    $("#jamSelesai").val(response.waktu_kembali);
                    $("#tujuan_1").val(response.tujuan_penggunaan_1);
                    $("#tujuan_2").val(response.tujuan_penggunaan_2);
                    $("#tujuan_3").val(response.tujuan_penggunaan_3);

                    // Render Kendaraan
                    const tbodyKendaraan = $("#kendaraanInfo tbody");
                    response.data_kendaraan.forEach((item, index) => {
                        tbodyKendaraan.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>
                                    <select name="nomor_kendaraan[]" class="form-control" onchange="updateKeterangan(this)">
                                        ${window.daftarKendaraanGlobal.map(k => `
                                            <option value="${k.id_kendaraan}" 
                                                    data-ket="${k.merk_kendaraan} - ${k.jenis_kendaraan}"
                                                    ${k.id_kendaraan === item.id_kendaraan ? 'selected' : ''}>
                                                ${k.nomor_kendaraan}
                                            </option>
                                        `).join('')}
                                    </select>
                                </td>
                                <td class="keterangan-kendaraan">${item.keterangan}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBoxEdit(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });


                    // Render Peserta
                    const tbodyPeserta = $("#pesertaList tbody");
                    response.userDinas.forEach((user, index) => {
                        tbodyPeserta.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${user.nrp_karyawan}</td>
                                <td>${user.name}</td>
                                <td>${user.departemen}</td>
                                <td><input type="checkbox" name="peserta[]" value="${user.nrp_karyawan}"></td>
                            </tr>
                        `);
                    });
                }
            },
            error: function () {
                alert("Gagal mengambil data. Coba lagi.");
            },
        });
    });

    function tambahComboBoxEdit() {
        const tbody = $("#kendaraanInfo tbody");
        const index = tbody.children().length + 1;

        const kendaraanOptions = window.daftarKendaraanGlobal.map(k => `
            <option value="${k.id_kendaraan}" data-ket="${k.merk_kendaraan} - ${k.jenis_kendaraan}">
                ${k.nomor_kendaraan}
            </option>
        `).join('');

        tbody.append(`
            <tr>
                <td>${index}</td>
                <td>
                    <select name="nomor_kendaraan[]" class="form-control" onchange="updateKeterangan(this)">
                        ${kendaraanOptions}
                    </select>
                </td>
                <td class="keterangan-kendaraan"></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusComboBoxEdit(this)">
                        <i class="fas fa-trash"></i>
                    </button>                
                </td>
            </tr>
        `);
    }



    function hapusComboBoxEdit(button) {
        $(button).closest('tr').remove();
    }

    function updateKeterangan(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const keterangan = selectedOption.getAttribute("data-ket") || '';
        
        const row = $(selectElement).closest("tr");
        row.find(".keterangan-kendaraan").text(keterangan);
    }






$(document).ready(function() {


    // Gunakan delegation

    $(document).on('click', '.update-status-kadeptybs', function() {
        var dataKDId = $(this).data('id');
        confirmUpdate(dataKDId, '/pengajuanDinas/update-status-kadeptybs');
    });

    $(document).on('click', '.update-status-kasietransportasi', function() {
        var dataKDId = $(this).data('id');
        confirmUpdate(dataKDId, '/pengajuanDinas/update-status-kasietransportasi');
    });

    // $(document).on('click', '.reject-status', function() {
    //     var dataKDId = $(this).data('id');
    //     confirmUpdate(dataKDId, '/pengajuanDinas/reject-status');
    // });


    // Common function to show confirmation and then update status
    function confirmUpdate(dataKDId, url) {
        Swal.fire({
            title: 'Konfirmasi Persetujuan',
            text: 'Apakah Anda menyetujui penggunaan kendaraan dinas dengan nomor ' + dataKDId + '?',
            icon: 'info',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Setuju!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading modal setelah klik "Ya, tolak!"
                Swal.fire({
                    title: 'Memproses...',
                    html: 'sedang menyimpan persetujuan anda.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
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
                        "Level 1": "Mengajukan",
                        "Level 2": "Menyetujui",
                        "Level 3": "Mengetahui",
                        "Level 4": "Memeriksa"
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
                    text: 'Apakah Anda yakin ingin menolak pengajuan Penggunaan Kendaraan Dinas dengan nomor ' + dataKDId + '?',
                    icon: 'error',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan loading modal setelah klik "Ya, tolak!"
                        Swal.fire({
                            title: 'Menolak Pengajuan...',
                            html: 'Mohon tunggu, sedang memproses penolakan.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
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
                                    title: 'Penolakan Berhasil!',
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