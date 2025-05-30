<?php

namespace App\Http\Controllers;

use App\Models\ApprovalBarangKeluar;
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

class ApprovalBarangKeluarController extends Controller
{
    public function getDetail(Request $request){
        $pengeluaranId = $request->pengeluaran_barang_id;
        $pengeluaranBarang = PengeluaranBarang::with('barangKeluar')->findOrFail($pengeluaranId);
        return response()->json($pengeluaranBarang,200);
    }
    
    private function generateApprovalId()
    {
        // Mendapatkan ID terakhir
        $lastId = ApprovalBarangKeluar::max('approval_id');
    
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
        $levelKaryawan = $user->level;

        try {
            // Ambil ID pengeluaran_barang dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
    
            // Update status pada tb_pencatatan_pengeluaran_barang
            $updatePengeluaran = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->update(['status' => 'Level 1']);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval_barang_keluar untuk tracking record
            // $approvalId = $this->generateApprovalId();
            $approval = ApprovalBarangKeluar::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 1',
                'created_date' => now(),
            ]);
    
            if (!$approval) {
                throw new \Exception('Gagal menambahkan data approval.');
            }

            //Mencari Email Pembawa
            $approval = ApprovalBarangKeluar::where('pengeluaran_barang_id', $pengeluaranBarangId)
            ->where('status_approval', 'Level 1')
            ->value('created_by');
        
            if (!$approval) {
                throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID : " . $pengeluaranBarangId);
            }
            
             //Mencari Email Pembawa
             $approval = ApprovalBarangKeluar::where('pengeluaran_barang_id', $pengeluaranBarangId)
             ->where('status_approval', 'Level 1')
             ->value('created_by');

            // Ambil email penerima berdasarkan created_by yang ditemukan
            $emailReceiver = User::where('nrp_karyawan', (string) $approval)->value('email');
            
            if (!$emailReceiver) {
                throw new \Exception('Email penerima tidak ditemukan.');
            }
        
            // Kirim email ke penerima
            $statusText = $this->getStatusText('Level 1');
            $userDepartment = $this->getDepartmentName($levelKaryawan);
            $this->sendApprovalEmail($emailReceiver, $pengeluaranBarangId, $user->name, $statusText, $userDepartment);
    
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan pengeluaran barang telah disetujui. Data persetujuan berhasil tersimpan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function updateNopolisi(Request $request)
    {
        DB::beginTransaction();
    
        try {
            // Ambil data dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
            $noPolisi = $request->input('no_polisi');
    
            // Update hanya tabel tb_pencatatan_pengeluaran_barang
            $updatePengeluaran = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->update([
                    'no_polisi' => $noPolisi,
                ]);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Data pengeluaran barang berhasil diperbarui!',
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
        $levelKaryawan = $user->level;

        try {
            // Ambil data dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
            $noPolisi = $request->input('no_polisi');
    
            // Update status pada tb_pencatatan_pengeluaran_barang menjadi "Level 5" dan update no_polisi
            $updatePengeluaran = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->update([
                    'status' => 'Level 6',
                    //'no_polisi' => $noPolisi,
                ]);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval_barang_keluar untuk tracking record
            // $approvalId = $this->generateApprovalId();
            $approval = ApprovalBarangKeluar::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 6',
                'created_date' => now(),
            ]);
    
            if (!$approval) {
                throw new \Exception('Gagal menambahkan data approval.');
            }

              //Mencari Email Pembawa
              $approval = ApprovalBarangKeluar::where('pengeluaran_barang_id', $pengeluaranBarangId)
              ->where('status_approval', 'Level 1')
              ->value('created_by');
          
              if (!$approval) {
                  throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID : " . $pengeluaranBarangId);
              }

                //Mencari Email Pembawa
                $approval = ApprovalBarangKeluar::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->where('status_approval', 'Level 1')
                ->value('created_by');
          
              // Ambil email penerima berdasarkan created_by yang ditemukan
              $emailReceiver = User::where('nrp_karyawan', (string) $approval)->value('email');
              
              if (!$emailReceiver) {
                  throw new \Exception('Email penerima tidak ditemukan.');
              }
          
              // Kirim email ke penerima
              $statusText = $this->getStatusText('Level 5');
              $userDepartment = $this->getDepartmentName($levelKaryawan);
              $this->sendApprovalEmail($emailReceiver, $pengeluaranBarangId, $user->name, $statusText, $userDepartment);
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan pengeluaran barang telah disetujui. Data persetujuan berhasil tersimpan.'
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
        $levelKaryawan = $user->level;

        try {
            // Ambil ID pengeluaran_barang dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
    
            // Update status pada tb_pencatatan_pengeluaran_barang
            $updatePengeluaran = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->update(['status' => 'Level 2']);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval_barang_keluar untuk tracking record
            //$approvalId = $this->generateApprovalId();
            $approval = ApprovalBarangKeluar::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 2',
                'created_date' => now(),
            ]);
          
              if (!$approval) {
                  throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID : " . $pengeluaranBarangId);
              }

                // Mencari NRP Pembawa dari approval Level 1
                $nrpPembawa = ApprovalBarangKeluar::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->where('status_approval', 'Level 1')
                ->value('created_by');

                if (!$nrpPembawa) {
                    throw new \Exception('NRP pembawa tidak ditemukan.');
                }

                // Ambil user pembawa
                $userPembawa = User::where('nrp_karyawan', (string) $nrpPembawa)->first();

                if (!$userPembawa) {
                    throw new \Exception('User pembawa tidak ditemukan.');
                }

                // Ambil email pembawa
                $emailPembawa = $userPembawa->email;

                if (!$emailPembawa) {
                    throw new \Exception('Email pembawa tidak ditemukan.');
                }

                // Kirim email ke pembawa barang
                $statusText = $this->getStatusText('Level 2');
                $userDepartment = $this->getDepartmentName($levelKaryawan);
                $this->sendApprovalEmail($emailPembawa, $pengeluaranBarangId, $user->name, $statusText, $userDepartment);


                // Cari kepala departemen dari pembawa
                $kepalaDept = User::where('departemen', $userPembawa->departemen)
                ->where('level', 'Ka.Dept')
                ->first();

                if (!$kepalaDept) {
                    throw new \Exception('Kepala departemen tidak ditemukan untuk departemen: ' . $userPembawa->departemen);
                }

                // Kirim email ke kepala departemen
                $this->sendApprovalEmail($kepalaDept->email, $pengeluaranBarangId, $user->name, $statusText, $userDepartment);


            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan pengeluaran barang telah disetujui. Data persetujuan berhasil tersimpan.'
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
        $levelKaryawan = $user->level;

        try {
            // Ambil ID pengeluaran_barang dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
    
            // Update status pada tb_pencatatan_pengeluaran_barang
            $updatePengeluaran = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->update(['status' => 'Level 3']);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval_barang_keluar untuk tracking record
            // $approvalId = $this->generateApprovalId();
            $approval = ApprovalBarangKeluar::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 3',
                'created_date' => now(),
            ]);
         
             if (!$approval) {
                 throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID : " . $pengeluaranBarangId);
             }

            //Mencari Email Pembawa
            $approval = ApprovalBarangKeluar::where('pengeluaran_barang_id', $pengeluaranBarangId)
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
             $this->sendApprovalEmail($emailReceiver, $pengeluaranBarangId, $user->name, $statusText, $userDepartment);

            // Cari email Ka.Dept GENERAL AFFAIRS
            $emailKaDeptGA = User::where('level', 'Ka.Dept')
            ->where('departemen', 'GENERAL AFFAIRS')
            ->value('email');

            if (!$emailKaDeptGA) {
                throw new \Exception('Email Ka.Dept GENERAL AFFAIRS tidak ditemukan.');
            }

            // Kirim email ke Ka.Dept GA
            $this->sendApprovalEmail($emailKaDeptGA, $pengeluaranBarangId, $user->name, $statusText, $userDepartment);

            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan pengeluaran barang telah disetujui. Data persetujuan berhasil tersimpan.'
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
        $levelKaryawan = $user->level;

        try {
            // Ambil ID pengeluaran_barang dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
    
            // Update status pada tb_pencatatan_pengeluaran_barang
            $updatePengeluaran = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->update(['status' => 'Level 4']);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval_barang_keluar untuk tracking record
            // $approvalId = $this->generateApprovalId();
            $approval = ApprovalBarangKeluar::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 4',
                'created_date' => now(),
            ]);
    
            if (!$approval) {
                throw new \Exception('Gagal menambahkan data approval.');
            }
    
              //Mencari Email Pembawa
              $approval = ApprovalBarangKeluar::where('pengeluaran_barang_id', $pengeluaranBarangId)
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
            $userDepartment = $this->getDepartmentName($levelKaryawan);
            $this->sendApprovalEmail($emailReceiver, $pengeluaranBarangId, $user->name, $statusText, $userDepartment);

            // Ambil ID pengeluaran_barang dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');

            // Ambil data lengkap pengeluaran barang
            $pengeluaranBarang = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)->first();
            if (!$pengeluaranBarang) {
                throw new \Exception('Data pengeluaran barang tidak ditemukan.');
            }

            // Jika kategori = 1 (Scrap), kirim email ke user Finance
            if ((int) $pengeluaranBarang->kategori_pengeluaran === 1) {
                $financeUsers = User::where('departemen', 'FINANCE')->pluck('email');

                foreach ($financeUsers as $financeEmail) {
                    $this->sendApprovalEmail($financeEmail, $pengeluaranBarangId, $user->name, $statusText, $userDepartment);
                }
            }

            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan pengeluaran barang telah disetujui. Data persetujuan berhasil tersimpan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateStatusFinance(Request $request)
    {
        DB::beginTransaction();
    
        $user = Auth::user();
        $nrpKaryawan = $user->nrp_karyawan;
        $levelKaryawan = $user->level;
    
        try {
            // Ambil ID pengeluaran_barang dari request
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
    
            // Ambil data pengeluaran_barang untuk memastikan kategori_pengeluaran = 1
            $pengeluaranBarang = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->where('kategori_pengeluaran', 1)
                ->first();
    
            if (!$pengeluaranBarang) {
                throw new \Exception('Data pengeluaran barang tidak ditemukan atau tidak termasuk kategori_pengeluaran = 1.');
            }
    
            // Update status ke Level 5
            $updatePengeluaran = $pengeluaranBarang->update(['status' => 'Level 5']);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Gagal memperbarui status pengeluaran barang.');
            }
    
            // Tambahkan data ke tb_approval_barang_keluar untuk tracking record (Level 5)
            $approval = ApprovalBarangKeluar::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 5',
                'created_date' => now(),
            ]);
    
            if (!$approval) {
                throw new \Exception('Gagal menambahkan data approval.');
            }
    
            // Mencari email pembawa (Level 1)
            $approvalLevel1 = ApprovalBarangKeluar::where('pengeluaran_barang_id', $pengeluaranBarangId)
                ->where('status_approval', 'Level 1')
                ->value('created_by');
    
            if (!$approvalLevel1) {
                throw new \Exception("Data approval dengan Level 1 tidak ditemukan untuk ID: " . $pengeluaranBarangId);
            }
    
            // Ambil email penerima berdasarkan created_by yang ditemukan
            $emailReceiver = User::where('nrp_karyawan', (string) $approvalLevel1)->value('email');
    
            if (!$emailReceiver) {
                throw new \Exception('Email penerima tidak ditemukan.');
            }
    
            // Kirim email ke penerima
            $statusText = $this->getStatusText('Level 5');
            $userDepartment = $this->getDepartmentName($levelKaryawan);
            $this->sendApprovalEmail($emailReceiver, $pengeluaranBarangId, $user->name, $statusText, $userDepartment);
    
          

            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan pengeluaran barang telah disetujui. Data persetujuan berhasil tersimpan.'
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
            $pengeluaranBarangId = $request->input('pengeluaran_barang_id');
            $alasan = $request->input('alasan');
    
            // Update status pada tb_pencatatan_pengeluaran_barang
            $updatePengeluaran = PengeluaranBarang::where('pengeluaran_barang_id', $pengeluaranBarangId)
              ->update([
                    'status' => 'Level 0',
                    'alasan_penolakan' => $alasan]);
    
            if (!$updatePengeluaran) {
                throw new \Exception('Pengeluaran barang tidak ditemukan atau gagal diperbarui.');
            }
    
            // Tambahkan data ke tb_approval_barang_keluar untuk tracking record
            ApprovalBarangKeluar::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 0',
                'created_date' => now(),
            ]);
    
            //Mencari Email Pembawa
            $approval = ApprovalBarangKeluar::where('pengeluaran_barang_id', $pengeluaranBarangId)
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
            $userDepartment = $this->getDepartmentName($levelKaryawan);
            $this->sendApprovalEmail($emailReceiver, $pengeluaranBarangId, $user->name, $statusText, $userDepartment, $alasan);
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan pengeluaran barang telah ditolak. Data penolakan berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

   private function sendApprovalEmail($userEmail, $pengeluaranBarangId, $approvedBy, $status, $fromDepartment, $reason = null)
    {
        Mail::to($userEmail)->send(new ApprovalNotification(
            $pengeluaranBarangId,
            $approvedBy,
            $status,
            $fromDepartment,
            $reason 
        ));
    }


    private function getStatusText($level)
    {
        $statusMap = [
            'Level 1' => 'Telah Mengajukan Sebagai Yang Membawa',
            'Level 2' => 'Telah Disetujui Sebagai Yang Mengeluarkan',
            'Level 3' => 'Telah Menyetujui dari Ka.Dept Ybs',
            'Level 4' => 'Telah Mengetahui dari Ka.Dept GA',
            'Level 5' => 'Telah Menerima dari Finance',
            'Level 6' => 'Telah Memeriksa oleh Security',
            'Level 6' => 'Telah Memeriksa oleh Security',
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
