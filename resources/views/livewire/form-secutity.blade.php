<div class ="content-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 mt-2 text-gray-800">Form Pengeluaran Barang</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pemeriksaan Barang</h6>
            </div>
            <div class="card-body">
                <table id="dataTable" class="display nowrap table-striped table" style="width:100%">
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
                        @foreach ($approvals as $approval)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $approval->pengeluaranBarang->pengeluaran_barang_id }}</td>
                                <td>
                                    @if ($approval->status_approval == 'Level 4')
                                        Menunggu Persetujuan
                                    @elseif ($approval->status_approval == 'Level 5')
                                        Sudah Disetujui
                                    @else
                                        {{ $approval->status_approval }}
                                    @endif
                                </td>
                                <td>
                                    @if ($approval->status_approval == 'Level 4')
                                        <button type="button" class="btn btn-success btn-sm" onclick="editApproval('{{ $approval->pengeluaranBarang->pengeluaran_barang_id }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @elseif ($approval->status_approval == 'Level 5')
                                        <button type="button" class="btn btn-info btn-sm" onclick="viewDetails(this)">
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

    <!-- Modal Edit Approval -->
    <div class="modal fade" id="editApprovalModal" tabindex="-1" aria-labelledby="editApprovalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editApprovalLabel">Edit Pengeluaran Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editApprovalForm">
                        <div class="mb-3">
                            <label for="pengeluaranBarangId" class="form-label">Nomor Pengeluaran Barang</label>
                            <input type="text" class="form-control" id="pengeluaranBarangId" name="pengeluaranBarangId" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="statusApproval" class="form-label">Status</label>
                            <select class="form-control" id="statusApproval" name="statusApproval">
                                <option value="Level 4">Menunggu Persetujuan</option>
                                <option value="Level 5">Sudah Disetujui</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="saveApproval()">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>




<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            columnDefs: [
                {className: 'dt-body-center',targets: 0},
                {className: 'dt-head-center',targets: 0},
                {className: 'dt-body-center',targets: 3},
                {className: 'dt-head-center',targets: 3}
            ],
              scrollX: true,
              responsive: true
        });
    });
    function editApproval(pengeluaranBarangId) {
        // Set data ke modal
        document.getElementById('pengeluaranBarangId').value = pengeluaranBarangId;
        document.getElementById('statusApproval').value = 'Level 4'; // Default value, ubah sesuai kebutuhan

        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById('editApprovalModal'));
        modal.show();
    }

    function saveApproval() {
        const form = document.getElementById('editApprovalForm');
        const pengeluaranBarangId = form.pengeluaranBarangId.value;
        const statusApproval = form.statusApproval.value;

        // Kirim data ke server (contoh AJAX)
        fetch('/save-approval', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ pengeluaranBarangId, statusApproval })
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  Swal.fire({
                      icon: 'success',
                      title: 'Berhasil!',
                      text: 'Data berhasil disimpan.'
                  });

                  // Refresh atau perbarui tabel
                  location.reload();
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Gagal!',
                      text: data.message || 'Terjadi kesalahan.'
                  });
              }
          });
    }
</script>