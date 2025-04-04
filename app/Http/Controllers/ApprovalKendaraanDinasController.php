<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ApprovalDinasNotification;
use App\Models\ApprovalKendaraanDinas;
use App\Models\SuratKendaraanDinas;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ApprovalKendaraanDinasController extends Controller
{
    public function updateStatusKaDeptYBS(Request $request)
    {
        DB::beginTransaction();

        $user = Auth::user();
        $nrpKaryawan = $user->nrp_karyawan;
        $levelKaryawan = $user->level;

        try {
            // Ambil ID pengeluaran_barang dari request
            $suratDinasId = $request->input('surat_kendaraan_dinas_id');
    
            // Update status pada tb_pencatatan_pengeluaran_barang
            $updatePengajuan = SuratKendaraanDinas::where('surat_kendaraan_dinas_id', $suratDinasId)
                ->update(['status' => 'Level 2']);
    
            if (!$updatePengajuan) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval_barang_keluar untuk tracking record
            // $approvalId = $this->generateApprovalId();
            $approval = ApprovalKendaraanDinas::create([
                'surat_kendaraan_dinas_id' => $suratDinasId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 2',
                'created_date' => now(),
            ]);
         
             if (!$approval) {
                 throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID : " . $suratDinasId);
             }

            //Mencari Email Pembawa
            $approval = ApprovalKendaraanDinas::where('surat_kendaraan_dinas_id', $suratDinasId)
            ->where('status_approval', 'Level 1')
            ->value('created_by');
         
             // Ambil email penerima berdasarkan created_by yang ditemukan
             $emailReceiver = User::where('nrp_karyawan', (string) $approval)->value('email');
             
             if (!$emailReceiver) {
                 throw new \Exception('Email penerima tidak ditemukan.');
             }
         
             // Kirim email ke penerima
             $statusText = $this->getStatusText('Level 2');
             $userDepartment = $this->getDepartmentName($levelKaryawan);
             $this->sendApprovalEmail($emailReceiver, $suratDinasId, $user->name, $statusText, $userDepartment);

            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui dan data approval ditambahkan!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateStatusKaSieTransport(Request $request)
    {
        DB::beginTransaction();

        $user = Auth::user();
        $nrpKaryawan = $user->nrp_karyawan;
        $levelKaryawan = $user->level;

        try {
            // Ambil ID pengeluaran_barang dari request
            $suratDinasId = $request->input('surat_kendaraan_dinas_id');
    
            // Update status pada tb_pencatatan_pengeluaran_barang
            $updatePengajuan = SuratKendaraanDinas::where('surat_kendaraan_dinas_id', $suratDinasId)
                ->update(['status' => 'Level 3']);
    
            if (!$updatePengajuan) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval_barang_keluar untuk tracking record
            // $approvalId = $this->generateApprovalId();
            $approval = ApprovalKendaraanDinas::create([
                'surat_kendaraan_dinas_id' => $suratDinasId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 3',
                'created_date' => now(),
            ]);
         
             if (!$approval) {
                 throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID : " . $suratDinasId);
             }

            //Mencari Email Pembawa
            $approval = ApprovalKendaraanDinas::where('surat_kendaraan_dinas_id', $suratDinasId)
            ->where('status_approval', 'Level 1')
            ->value('created_by');
         
             // Ambil email penerima berdasarkan created_by yang ditemukan
             $emailReceiver = User::where('nrp_karyawan', (string) $approval)->value('email');
             
             if (!$emailReceiver) {
                 throw new \Exception('Email penerima tidak ditemukan.');
             }
         
             // Kirim email ke penerima
             $statusText = $this->getStatusText('Level 3');
             $userDepartment = $this->getDepartmentName($levelKaryawan);
             $this->sendApprovalEmail($emailReceiver, $suratDinasId, $user->name, $statusText, $userDepartment);

            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui dan data approval ditambahkan!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function rejectStatus(Request $request)
    {
        DB::beginTransaction();

        $user = Auth::user();
        $nrpKaryawan = $user->nrp_karyawan;
        $levelKaryawan = $user->level;

        try {
            // Ambil ID pengeluaran_barang dari request
            $suratDinasId = $request->input('surat_kendaraan_dinas_id');
    
            // Update status pada tb_pencatatan_pengeluaran_barang
            $updatePengajuan = SuratKendaraanDinas::where('surat_kendaraan_dinas_id', $suratDinasId)
                ->update(['status' => 'Level 0']);
    
            if (!$updatePengajuan) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval_barang_keluar untuk tracking record
            // $approvalId = $this->generateApprovalId();
            $approval = ApprovalKendaraanDinas::create([
                'surat_kendaraan_dinas_id' => $suratDinasId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 0',
                'created_date' => now(),
            ]);
         
             if (!$approval) {
                 throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID : " . $suratDinasId);
             }

            //Mencari Email Pembawa
            $approval = ApprovalKendaraanDinas::where('surat_kendaraan_dinas_id', $suratDinasId)
            ->where('status_approval', 'Level 1')
            ->value('created_by');
         
             // Ambil email penerima berdasarkan created_by yang ditemukan
             $emailReceiver = User::where('nrp_karyawan', (string) $approval)->value('email');
             
             if (!$emailReceiver) {
                 throw new \Exception('Email penerima tidak ditemukan.');
             }
         
             // Kirim email ke penerima
             $statusText = $this->getStatusText('Level 0');
             $userDepartment = $this->getDepartmentName($levelKaryawan);
             $this->sendApprovalEmail($emailReceiver, $suratDinasId, $user->name, $statusText, $userDepartment);

            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui dan data approval ditambahkan!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function sendApprovalEmail($userEmail, $suratDinasId, $approvedBy, $status, $fromDepartment)
    {
        Mail::to($userEmail)->send(new ApprovalDinasNotification($suratDinasId, $approvedBy, $status, $fromDepartment));
    }

    private function getStatusText($level)
    {
        $statusMap = [
            'Level 1' => 'Telah Mengajukan Sebagai Yang Membawa',
            'Level 2' => 'Telah Menyetujui dari Ka.Dept Ybs',
            'Level 3' => 'Telah Menyetujui dari Ka.Sie Transport GA',
            'Level 4' => 'Telah Memeriksa oleh Security',
        ];

        return $statusMap[$level] ?? 'Ditolak';
    }

    private function getDepartmentName($departmentId)
    {
        $statusDepartmentMap = [
            'Staff' => 'Staff',
            'Ka.Sie' => 'PIC/Ka.Sie',
            'Ka.Dept' => 'Ka.Dept',
            'Security' => 'Security',
        ];

        return $statusDepartmentMap[$departmentId] ?? 'Tidak Diketahui';
    }
}
