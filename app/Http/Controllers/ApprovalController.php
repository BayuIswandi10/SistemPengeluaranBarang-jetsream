<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\PengeluaranBarang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalNotification;
use Endroid\QrCode\QrCode as QrCodeQrCode;

class ApprovalController extends Controller
{
    public function getDetail(Request $request){
        $pengeluaranId = $request->pengeluaran_barang_id;
        $pengeluaranBarang = PengeluaranBarang::with('barangKeluar')->findOrFail($pengeluaranId);
        return response()->json($pengeluaranBarang,200);
    }
    
    private function generateApprovalId()
    {
        // Mendapatkan ID terakhir
        $lastId = Approval::max('approval_id');
    
        // Jika belum ada ID, mulai dari APR0001
        if (!$lastId) {
            return 'APR0001';
        }
    
        // Ekstrak angka dari ID terakhir dan increment
        $lastNumber = (int) substr($lastId, 3);
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    
        return 'APR' . $newNumber;
    }

    public function updateStatus(Request $request)
    {
        DB::beginTransaction();

        $user = Auth::user();
        $nrpKaryawan = $user->nrp_karyawan;

        try {
            // Ambil ID pengeluaran_barang dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
    
            // Update status pada tb_pengeluaran_barang
            $updatePengeluaran = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->update(['status' => 'Level 1']);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval untuk tracking record
            // $approvalId = $this->generateApprovalId();
            $approval = Approval::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 1',
                'created_date' => now(),
            ]);
    
            if (!$approval) {
                throw new \Exception('Gagal menambahkan data approval.');
            }

            //Mencari Email Pembawa
            $approval = Approval::where('pengeluaran_barang_id', $pengeluaranBarangId)
            ->where('status_approval', 'Level 1')
            ->value('created_by');
        
            if (!$approval) {
                throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID : " . $pengeluaranBarangId);
            }
        
            // Ambil email penerima berdasarkan created_by yang ditemukan
            $emailReceiver = User::where('nrp_karyawan', (string) $approval)->value('email');
            
            if (!$emailReceiver) {
                throw new \Exception('Email penerima tidak ditemukan.');
            }
        
            // Kirim email ke penerima
            $statusText = $this->getStatusText('Level 1');
            $this->sendApprovalEmail($emailReceiver, $pengeluaranBarangId, $user->name, $statusText);
    
    
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


    public function updateStatusSecurity(Request $request)
    {
        DB::beginTransaction();

        $user = Auth::user();
        $nrpKaryawan = $user->nrp_karyawan;

        try {
            // Ambil data dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
            $noPolisi = $request->input('no_polisi');
    
            // Update status pada tb_pengeluaran_barang menjadi "Level 5" dan update no_polisi
            $updatePengeluaran = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->update([
                    'status' => 'Level 5',
                    'no_polisi' => $noPolisi,
                ]);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval untuk tracking record
            // $approvalId = $this->generateApprovalId();
            $approval = Approval::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 5',
                'created_date' => now(),
            ]);
    
            if (!$approval) {
                throw new \Exception('Gagal menambahkan data approval.');
            }

              //Mencari Email Pembawa
              $approval = Approval::where('pengeluaran_barang_id', $pengeluaranBarangId)
              ->where('status_approval', 'Level 1')
              ->value('created_by');
          
              if (!$approval) {
                  throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID : " . $pengeluaranBarangId);
              }
          
              // Ambil email penerima berdasarkan created_by yang ditemukan
              $emailReceiver = User::where('nrp_karyawan', (string) $approval)->value('email');
              
              if (!$emailReceiver) {
                  throw new \Exception('Email penerima tidak ditemukan.');
              }
          
              // Kirim email ke penerima
              $statusText = $this->getStatusText('Level 5');
              $this->sendApprovalEmail($emailReceiver, $pengeluaranBarangId, $user->name, $statusText);
    
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

    public function updateStatusKaSie(Request $request)
    {
        DB::beginTransaction();

        $user = Auth::user();
        $nrpKaryawan = $user->nrp_karyawan;

        try {
            // Ambil ID pengeluaran_barang dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
    
            // Update status pada tb_pengeluaran_barang
            $updatePengeluaran = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->update(['status' => 'Level 2']);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval untuk tracking record
            //$approvalId = $this->generateApprovalId();
            $approval = Approval::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 2',
                'created_date' => now(),
            ]);
          
              if (!$approval) {
                  throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID : " . $pengeluaranBarangId);
              }
          
              // Ambil email penerima berdasarkan created_by yang ditemukan
              $emailReceiver = User::where('nrp_karyawan', (string) $approval)->value('email');
              
              if (!$emailReceiver) {
                  throw new \Exception('Email penerima tidak ditemukan.');
              }
          
              // Kirim email ke penerima
              $statusText = $this->getStatusText('Level 2');
              $this->sendApprovalEmail($emailReceiver, $pengeluaranBarangId, $user->name, $statusText);

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

    public function updateStatusKaDeptYBS(Request $request)
    {
        DB::beginTransaction();

        $user = Auth::user();
        $nrpKaryawan = $user->nrp_karyawan;

        try {
            // Ambil ID pengeluaran_barang dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
    
            // Update status pada tb_pengeluaran_barang
            $updatePengeluaran = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->update(['status' => 'Level 3']);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval untuk tracking record
            // $approvalId = $this->generateApprovalId();
            $approval = Approval::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 3',
                'created_date' => now(),
            ]);
         
             if (!$approval) {
                 throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID : " . $pengeluaranBarangId);
             }
         
             // Ambil email penerima berdasarkan created_by yang ditemukan
             $emailReceiver = User::where('nrp_karyawan', (string) $approval)->value('email');
             
             if (!$emailReceiver) {
                 throw new \Exception('Email penerima tidak ditemukan.');
             }
         
             // Kirim email ke penerima
             $statusText = $this->getStatusText('Level 3');
             $this->sendApprovalEmail($emailReceiver, $pengeluaranBarangId, $user->name, $statusText);

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

    public function updateStatusKaDeptGA(Request $request)
    {
        DB::beginTransaction();

        $user = Auth::user();
        $nrpKaryawan = $user->nrp_karyawan;

        try {
            // Ambil ID pengeluaran_barang dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
    
            // Update status pada tb_pengeluaran_barang
            $updatePengeluaran = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->update(['status' => 'Level 4']);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval untuk tracking record
            // $approvalId = $this->generateApprovalId();
            $approval = Approval::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 4',
                'created_date' => now(),
            ]);
    
            if (!$approval) {
                throw new \Exception('Gagal menambahkan data approval.');
            }
    
              //Mencari Email Pembawa
              $approval = Approval::where('pengeluaran_barang_id', $pengeluaranBarangId)
              ->where('status_approval', 'Level 1')
              ->value('created_by');
          
              if (!$approval) {
                  throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID : " . $pengeluaranBarangId);
              }
          
              // Ambil email penerima berdasarkan created_by yang ditemukan
              $emailReceiver = User::where('nrp_karyawan', (string) $approval)->value('email');
              
              if (!$emailReceiver) {
                  throw new \Exception('Email penerima tidak ditemukan.');
              }
          
              // Kirim email ke penerima
              $statusText = $this->getStatusText('Level 4');
              $this->sendApprovalEmail($emailReceiver, $pengeluaranBarangId, $user->name, $statusText);

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
    
        try {
            // Ambil ID pengeluaran_barang dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
    
            // Update status pada tb_pengeluaran_barang
            $updatePengeluaran = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->update(['status' => 'Level 0']);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval untuk tracking record
            Approval::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 0',
                'created_date' => now(),
            ]);
    
            //Mencari Email Pembawa
            $approval = Approval::where('pengeluaran_barang_id', $pengeluaranBarangId)
            ->where('status_approval', 'Level 1')
            ->value('created_by');
        
            if (!$approval) {
                throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID : " . $pengeluaranBarangId);
            }
        
            // Ambil email penerima berdasarkan created_by yang ditemukan
            $emailReceiver = User::where('nrp_karyawan', (string) $approval)->value('email');
            
            if (!$emailReceiver) {
                throw new \Exception('Email penerima tidak ditemukan.');
            }
        
            // Kirim email ke penerima
            $statusText = $this->getStatusText('Level 0');
            $this->sendApprovalEmail($emailReceiver, $pengeluaranBarangId, $user->name, $statusText);
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui dan email telah dikirim!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function sendApprovalEmail($userEmail, $pengeluaranBarangId, $approvedBy, $status)
    {
        // // Buat QR code
        // $qrCode = new QrCode($pengeluaranBarangId);
        // $qrCode->size(200);
        // $qrCode->setMargin(10);

        // // Konversi QR code ke base64
        // $writer = new PngWriter();
        // $qrCodeImage = $writer->write($qrCode);
        // $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrCodeImage->getString());

        // Kirim email dengan QR code
        Mail::to($userEmail)->send(new ApprovalNotification($pengeluaranBarangId, $approvedBy, $status));
    }

    
    
    private function getStatusText($level)
    {
        $statusMap = [
            'Level 1' => 'Telah Mengajukan Sebagai Yang Membawa',
            'Level 2' => 'Telah Disetujui Sebagai Yang Mengeluarkan',
            'Level 3' => 'Telah Menyetujui dari Ka.Dept Ybs',
            'Level 4' => 'Telah Mengetahui dari Ka.Dept GA',
            'Level 5' => 'Telah Memeriksa oleh Security',
        ];

        return $statusMap[$level] ?? 'Ditolak';
    }


}
