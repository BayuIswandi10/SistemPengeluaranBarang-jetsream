<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KendaraanDinas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class KendaraanDinasController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */

    public function getDataTersedia(Request $request)
    {
        try {
            $kendaraan = DB::table('tb_kendaraan_dinas')
                ->select(
                    'kendaraan_dinas_id',
                    'merk_kendaraan',
                    'jenis_kendaraan',
                    'nomor_kendaraan',
                    'kapasitas_kendaraan',
                    'status_kendaraan'
                )
                ->get();
    
            return response()->json($kendaraan);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data kendaraan: ' . $e->getMessage()
            ], 500);
        }
    }
     
    public function getDataDigunakan(Request $request)
    {
        try {
            $kendaraan = DB::table('tb_kendaraan_dinas')
                ->select(
                    'kendaraan_dinas_id',
                    'merk_kendaraan',
                    'jenis_kendaraan',
                    'nomor_kendaraan',
                    'kapasitas_kendaraan',
                    'status_kendaraan'
                )
                ->where('status_kendaraan', 2) // hanya ambil yang status = 2
                ->get();
    
            return response()->json($kendaraan);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data kendaraan: ' . $e->getMessage()
            ], 500);
        }
    }
    

    public function store(Request $request)
    {
        $user = Auth::user();
        $nrpKaryawan = $user->nrp_karyawan;
        $validator = Validator::make($request->all(), [
            'jenis_kendaraan' => 'required|integer',
            'nomor_kendaraan' => [
                'required',
                'string',
                'max:15',
                'regex:/^[A-Z]{1,2} \d{1,4} [A-Z]{1,3}$/',
                Rule::unique('tb_kendaraan_dinas', 'nomor_kendaraan')
            ],
            'kapasitas_kendaraan' => 'required|integer|min:1',
            'merk_kendaraan' => 'required|string|max:50',
        ], [
            'merk_kendaraan.required' => 'Merk kendaraan harus diisi.',
            'merk_kendaraan.string' => 'Merk kendaraan harus berupa teks.',
            'merk_kendaraan.max' => 'Merk kendaraan tidak boleh lebih dari 50 karakter.',
            'jenis_kendaraan.required' => 'Jenis kendaraan harus diisi.',
            'jenis_kendaraan.integer' => 'Jenis kendaraan harus berupa angka.',
            'nomor_kendaraan.required' => 'Nomor kendaraan harus diisi.',
            'nomor_kendaraan.string' => 'Nomor kendaraan harus berupa teks.',
            'nomor_kendaraan.max' => 'Nomor kendaraan tidak boleh lebih dari 15 karakter.',
            'nomor_kendaraan.regex' => 'Format nomor kendaraan tidak valid. Contoh: B 1234 ABC',
            'nomor_kendaraan.unique' => 'Nomor kendaraan sudah terdaftar.',
            'kapasitas_kendaraan.required' => 'Kapasitas kendaraan harus diisi.',
            'kapasitas_kendaraan.integer' => 'Kapasitas kendaraan harus berupa angka.',
            'kapasitas_kendaraan.min' => 'Kapasitas kendaraan minimal 1 penumpang.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }
    
        try {
            // Simpan data kendaraan baru (kendaraan_dinas_id otomatis di-generate)
            KendaraanDinas::create([
                'merk_kendaraan' => $request->merk_kendaraan,
                'jenis_kendaraan' => $request->jenis_kendaraan,
                'nomor_kendaraan' => $request->nomor_kendaraan,
                'kapasitas_kendaraan' => $request->kapasitas_kendaraan,
                'status_kendaraan' => 1, // 1 = Tersedia
                'created_by' => $nrpKaryawan,
                'created_date' => now(),
            ]);
    
            return redirect()->back()->with('success', 'Data kendaraan berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $kendaraanId = $request->kendaraan_dinas_id;
        $kendaraan = KendaraanDinas::findOrFail($kendaraanId);
        return response()->json([
            'kendaraan_dinas_id'      => $kendaraan->kendaraan_dinas_id,
            'jenis_kendaraan'            => $kendaraan->jenis_kendaraan,
            'merk_kendaraan'             => $kendaraan->merk_kendaraan,
            'nomor_kendaraan'            => $kendaraan->nomor_kendaraan,
            'kapasitas_kendaraan'        => $kendaraan->kapasitas_kendaraan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $nrpKaryawan = $user->nrp_karyawan;
        $id = $request->kendaraan_dinas_id;
    
        $validator = Validator::make($request->all(), [
            'jenis_kendaraan' => 'required|integer',
            'nomor_kendaraan' => [
                'required',
                'string',
                'max:15',
                'regex:/^[A-Z]{1,2} \d{1,4} [A-Z]{1,3}$/',
                Rule::unique('tb_kendaraan_dinas', 'nomor_kendaraan')->ignore($id, 'kendaraan_dinas_id'),
            ],
            'kapasitas_kendaraan' => 'required|integer|min:1',
        ], [
            'jenis_kendaraan.required' => 'Jenis kendaraan harus diisi.',
            'jenis_kendaraan.integer' => 'Jenis kendaraan harus berupa angka.',
            'nomor_kendaraan.required' => 'Nomor kendaraan harus diisi.',
            'nomor_kendaraan.string' => 'Nomor kendaraan harus berupa teks.',
            'nomor_kendaraan.max' => 'Nomor kendaraan tidak boleh lebih dari 15 karakter.',
            'nomor_kendaraan.unique' => 'Nomor kendaraan sudah terdaftar.',
            'kapasitas_kendaraan.required' => 'Kapasitas kendaraan harus diisi.',
            'kapasitas_kendaraan.integer' => 'Kapasitas kendaraan harus berupa angka.',
            'kapasitas_kendaraan.min' => 'Kapasitas kendaraan minimal 1 penumpang.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }
    
        try {
            $kendaraan = KendaraanDinas::findOrFail($id);
            $kendaraan->update([
                'jenis_kendaraan' => $request->jenis_kendaraan,
                'nomor_kendaraan' => $request->nomor_kendaraan,
                'merk_kendaraan' => $request->merk_kendaraan,
                'kapasitas_kendaraan' => $request->kapasitas_kendaraan,
                'updated_by' => $nrpKaryawan,
                'updated_date' => now(),
            ]);
    
            return redirect()->back()->with('success', 'Data kendaraan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function nonAktif(Request $request)
    {
        try {
            $id = $request->input('kendaraan_dinas_id');
            $kendaraan = KendaraanDinas::findOrFail($id);
    
            $kendaraan->update([
                'status_kendaraan' => 0,
                'updated_by' => Auth::user()->nrp_karyawan,
                'updated_at' => now(),
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Kendaraan berhasil dinonaktifkan.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function getRiwayatSurat($id)
    {
        try {
            $surats = DB::table('tb_surat_kendaraan_dinas_detail as detail')
                ->join('tb_surat_kendaraan_dinas as surat', 'detail.surat_kendaraan_dinas_id', '=', 'surat.surat_kendaraan_dinas_id')
                ->where('detail.kendaraan_dinas_id', $id)
                ->orderBy('surat.tanggal_penggunaan', 'desc')
                ->select(
                    'surat.surat_kendaraan_dinas_id',
                    DB::raw("CONCAT_WS(' - ', surat.tujuan_penggunaan_1, surat.tujuan_penggunaan_2, surat.tujuan_penggunaan_3) as tujuan_penggunaan"),
                    'surat.tanggal_penggunaan',
                    'surat.waktu_keluar',
                    'surat.waktu_kembali',
                    'surat.status'
                )
                ->get();
    
            return response()->json($surats);
        } catch (\Exception $e) {
            // \Log::error('RiwayatSurat Error: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }    

    public function getAllBookingDates()
    {
        try {
            $data = DB::table('tb_surat_kendaraan_dinas_detail as skdd')
                ->join('tb_surat_kendaraan_dinas as skd', 'skdd.surat_kendaraan_dinas_id', '=', 'skd.surat_kendaraan_dinas_id')
                ->join('tb_kendaraan_dinas as kd', 'skdd.kendaraan_dinas_id', '=', 'kd.kendaraan_dinas_id')
                ->leftJoin('tb_pencatatan_kendaraan_dinas as pkdd', 'skd.surat_kendaraan_dinas_id', '=', 'pkdd.surat_kendaraan_dinas_id')
                ->select(
                    'kd.kendaraan_dinas_id',
                    'kd.merk_kendaraan',
                    'kd.nomor_kendaraan',
                    'kd.kapasitas_kendaraan',
                    'skd.tanggal_penggunaan',
                    'skd.surat_kendaraan_dinas_id',
                    'skd.status',
                    'skd.jenis_kendaraan',
                    DB::raw('COUNT(pkdd.nrp_karyawan) as total_terpakai'),
                    DB::raw('(kd.kapasitas_kendaraan - COUNT(pkdd.nrp_karyawan) - 1) as kapasitas_tersedia')
                )
                ->groupBy(
                    'kd.kendaraan_dinas_id',
                    'kd.merk_kendaraan',
                    'kd.nomor_kendaraan',
                    'kd.kapasitas_kendaraan',
                    'skd.tanggal_penggunaan',
                    'skd.surat_kendaraan_dinas_id',
                    'skd.status',
                    'skd.jenis_kendaraan'
                )
                ->get();
    
            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('AllBookingDates Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return response()->json([
                'error' => 'Terjadi kesalahan di server',
                'debug' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }
    
    public function getKendaraanByJenis(Request $request)
    {
        $jenis = $request->jenis_kendaraan;

        // Validasi jenis kendaraan
        if (!$jenis) {
            return response()->json(['message' => 'Jenis kendaraan tidak ditemukan'], 400);
        }

        // Ambil data kendaraan berdasarkan jenis
        $kendaraan = KendaraanDinas::where('jenis_kendaraan', $jenis)
                        ->select('kendaraan_dinas_id', 'nomor_kendaraan', 'merk_kendaraan', 'kapasitas_kendaraan')
                        ->orderBy('nomor_kendaraan')
                        ->get();

        return response()->json($kendaraan);
    }

    
}
