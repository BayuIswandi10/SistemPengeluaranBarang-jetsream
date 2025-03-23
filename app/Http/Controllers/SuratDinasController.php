<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratKendaraanDinas;
use App\Models\User;
use App\Models\PencatatanKendaraanDinas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SuratDinasController extends Controller
{
    /**
     * Generate Surat Dinas ID
     */
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
        $request->validate([
            'tujuan_penggunaan_1' => 'required|string|max:35',
            'tujuan_penggunaan_2' => 'nullable|string|max:35',
            'tujuan_penggunaan_3' => 'nullable|string|max:35',
            'tanggal_penggunaan' => 'required|date',
            'jenis_kendaraan' => 'required|in:1,2,3',
            'created_by' => 'required|string',
            'waktu_keluar' => 'required',
            'waktu_kembali' => 'required',
            'peserta' => 'nullable|array', // Memastikan peserta dikirim dalam bentuk array
            'peserta.*.nrp_karyawan' => 'required|string', // Validasi setiap peserta harus memiliki nrp_karyawan
        ]);
    
        DB::beginTransaction();
        try {
            $nrpKaryawan = $request->input('created_by');
            $user = User::where('nrp_karyawan', $nrpKaryawan)->first();
            if (!$user) {
                return redirect()->back()->with('error', 'NRP tidak ditemukan!')->withInput();
            }
    
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
    
            DB::commit();
            return redirect()->back()->with('success', 'Surat Dinas berhasil disimpan dengan ID: ' . $suratDinasID);
    
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menyimpan surat dinas: ' . $e->getMessage());
        }
    }
    
}
