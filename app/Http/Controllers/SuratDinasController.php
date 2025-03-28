<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratKendaraanDinas;
use App\Models\User;
use App\Models\PencatatanKendaraanDinas;
use Illuminate\Support\Facades\DB;
use App\Models\ApprovalKendaraanDinas;
use Illuminate\Support\Facades\Validator;

class SuratDinasController extends Controller
{
    /**
     * Generate Surat Dinas ID
     */

     public function getUserDetails(Request $request)
     {
         $user = User::where('nrp_karyawan', $request->nrp_karyawan)->first();
     
         if ($user) {
             return response()->json([
                 'success' => true,
                 'data' => [
                     'name' => $user->name,
                     'departemen' => $user->departemen
                 ]
             ]);
         } else {
             return response()->json(['success' => false]);
         }
     }
    private function generateSuratDinasID($jenisKendaraan, $tanggalPenggunaan)
    {
        // Mapping jenis kendaraan
        $jenisKendaraanMap = [
            '1' => 'KN', // KANTOR
            '2' => 'PR', // PRIBADI
            '3' => 'TX', // TAXI
        ];

        // Ambil kode kendaraan
        $jenisKendaraanCode = $jenisKendaraanMap[$jenisKendaraan] ?? 'UK';

        // Format tanggal
        $tanggalFormat = date('dmY', strtotime($tanggalPenggunaan));

        // Ambil nomor urut terakhir untuk tanggal tersebut
        $lastSurat = SuratKendaraanDinas::where('surat_kendaraan_dinas_id', 'LIKE', "{$jenisKendaraanCode}/{$tanggalFormat}/%")
                        ->orderBy('surat_kendaraan_dinas_id', 'desc')
                        ->first();

        // Tentukan nomor urut selanjutnya
        $nextNumber = 1;
        if ($lastSurat) {
            $lastNumber = (int) substr($lastSurat->surat_kendaraan_dinas_id, -4);
            $nextNumber = $lastNumber + 1;
        }

        // Format ID
        return sprintf("%s/%s/%04d", $jenisKendaraanCode, $tanggalFormat, $nextNumber);
    }

    /**
     * Store Surat Dinas
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'tujuan_penggunaan_1' => 'required|string|max:35',
            'tujuan_penggunaan_2' => 'nullable|string|max:35',
            'tujuan_penggunaan_3' => 'nullable|string|max:35',
            'tanggal_penggunaan' => 'required|date|after_or_equal:today',
            'jenis_kendaraan' => 'required|in:1,2,3',
            'created_by' => 'required|string',
            'waktu_keluar' => 'required|date_format:H:i',
            'waktu_kembali' => 'required|date_format:H:i|after:waktu_keluar',
            'peserta' => 'nullable|array', // Memastikan peserta dikirim dalam bentuk array
            'peserta.*.nrp_karyawan' => 'required|string', // Validasi setiap peserta harus memiliki nrp_karyawan
        ], [
            'tujuan_penggunaan_1.required' => 'Tujuan penggunaan utama wajib diisi.',
            'tujuan_penggunaan_1.string' => 'Tujuan penggunaan harus berupa teks.',
            'tujuan_penggunaan_1.max' => 'Tujuan penggunaan maksimal 35 karakter.',
            
            'tujuan_penggunaan_2.string' => 'Tujuan penggunaan harus berupa teks.',
            'tujuan_penggunaan_2.max' => 'Tujuan penggunaan maksimal 35 karakter.',
            
            'tujuan_penggunaan_3.string' => 'Tujuan penggunaan harus berupa teks.',
            'tujuan_penggunaan_3.max' => 'Tujuan penggunaan maksimal 35 karakter.',
        
            'tanggal_penggunaan.required' => 'Tanggal penggunaan wajib diisi.',
            'tanggal_penggunaan.date' => 'Format tanggal tidak valid.',
            'tanggal_penggunaan.after_or_equal' => 'Tanggal penggunaan minimal harus hari ini.',
        
            'jenis_kendaraan.required' => 'Jenis kendaraan wajib dipilih.',
            'jenis_kendaraan.in' => 'Jenis kendaraan tidak valid.',
        
            'created_by.required' => 'NRP pembuat wajib diisi.',
            'created_by.string' => 'NRP pembuat harus berupa teks.',
        
            'waktu_keluar.required' => 'Waktu keluar wajib diisi.',
            'waktu_keluar.date_format' => 'Format waktu keluar harus HH:MM (jam:menit).',
        
            'waktu_kembali.required' => 'Waktu kembali wajib diisi.',
            'waktu_kembali.date_format' => 'Format waktu kembali harus HH:MM (jam:menit).',
            'waktu_kembali.after' => 'Waktu kembali harus setelah waktu keluar.',
        
            'peserta.array' => 'Data peserta harus dalam format array.',
            'peserta.*.nrp_karyawan.required' => 'NRP peserta wajib diisi.',
            'peserta.*.nrp_karyawan.string' => 'NRP peserta harus berupa teks.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }
        
        $nrpKaryawan = $request->input('created_by');
        $tanggalPenggunaan = $request->input('tanggal_penggunaan');

        $user = User::where('nrp_karyawan', $nrpKaryawan)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'NRP tidak terdaftar!')->withInput();
        }

        // Cek apakah user sudah mengajukan atau sudah diajukan pada tanggal yang sama
        $existingRequest = SuratKendaraanDinas::where('created_by', $nrpKaryawan)
        ->whereDate('tanggal_penggunaan', $tanggalPenggunaan)
        ->exists();

        if ($existingRequest) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan kendaraan dinas pada tanggal ini.')->withInput();
        }

        // Cek apakah peserta yang diajukan sudah memiliki pengajuan di tanggal yang sama
        if ($request->has('peserta') && is_array($request->peserta)) {
            foreach ($request->peserta as $peserta) {
                $existsAsParticipant = PencatatanKendaraanDinas::where('nrp_karyawan', $peserta['nrp_karyawan'])
                    ->whereHas('suratKendaraanDinas', function ($query) use ($tanggalPenggunaan) {
                        $query->whereDate('tanggal_penggunaan', $tanggalPenggunaan);
                    })
                    ->exists();

                if ($existsAsParticipant) {
                    return redirect()->back()->with('error', 'Peserta dengan NRP ' . $peserta['nrp_karyawan'] . ' sudah diajukan di tanggal yang sama.')->withInput();
                }
            }
        }

        DB::beginTransaction();
        try {
    
            // Generate surat_dinas_id
            $suratDinasID = $this->generateSuratDinasID($request->jenis_kendaraan, $request->tanggal_penggunaan);
    
            // Simpan ke database tb_surat_kendaraan_dinas
            $suratDinas = SuratKendaraanDinas::create([
                'surat_kendaraan_dinas_id' => $suratDinasID,
                'tujuan_penggunaan_1' => $request->tujuan_penggunaan_1,
                'tujuan_penggunaan_2' => $request->tujuan_penggunaan_2,
                'tujuan_penggunaan_3' => $request->tujuan_penggunaan_3,
                'tanggal_penggunaan' => $request->tanggal_penggunaan,
                'jenis_kendaraan' => $request->jenis_kendaraan,
                'created_by' => $nrpKaryawan,
                'created_date' => now(),
                'status' => 'Pending',
                'waktu_keluar' => $request->waktu_keluar,
                'waktu_kembali' => $request->waktu_kembali,
            ]);
    
            // Cek apakah ada peserta yang dikirim
            if ($request->has('peserta') && is_array($request->peserta)) {
                foreach ($request->peserta as $peserta) {
                    $nrp = $peserta['nrp_karyawan'];

                    //Cek NRP peserta di tabel users
                    $userExists = User::where('nrp_karyawan', $nrp)->exists();
        
                    if (!$userExists) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'NRP peserta ' . $nrp . ' tidak terdaftar!')->withInput();
                    }
                    // Pastikan NRP peserta tidak kosong
                    if (!empty($peserta['nrp_karyawan'])) {
                        PencatatanKendaraanDinas::create([
                            'nrp_karyawan' => $peserta['nrp_karyawan'],
                            'surat_kendaraan_dinas_id' => $suratDinas->surat_kendaraan_dinas_id,
                            'update_date' => now(),
                        ]);
                    }
                }
            }

            // Insert ke tabel tb_approval_barang_keluar
            ApprovalKendaraanDinas::create([
                'surat_kendaraan_dinas_id' => $suratDinasID,
                'created_by' => $nrpKaryawan,
                'created_date' => now(),
                'status_approval' => 'Level 1',
            ]);
    
            DB::commit();
            return redirect()->back()->with('success', 'Surat Dinas berhasil disimpan dengan ID: ' . $suratDinasID);
    
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menyimpan surat dinas: ' . $e->getMessage());
        }
    }
    
}
