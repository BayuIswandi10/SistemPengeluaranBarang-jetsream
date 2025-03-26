<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengeluaranBarang;
use App\Models\BarangKeluar;
use App\Models\ApprovalBarangKeluar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class PengeluaranBarangController extends Controller
{
    public function index()
    {
        $pengeluaranBarangs = PengeluaranBarang::with('approval')->get(); 
        return view('livewire.form-pengeluaran', compact('pengeluaranBarangs'));
    }

    public function getDataLevel4()
    {
        $pengeluaranBarangs = PengeluaranBarang::where(function ($query) {
            $query->where('kategori_pengeluaran', 1)->where('status', 'Level 5') // Jika kategori 1, harus Level 5
                  ->orWhere('kategori_pengeluaran', 0)->where('status', 'Level 4'); // Jika kategori 0, cukup Level 4
        })->get();
    
        return response()->json(['barang_keluar' => $pengeluaranBarangs]);
    }
    

    public function getDetail(Request $request)
    {
        $pengeluaranId = $request->pengeluaran_barang_id;

        // Mengambil data pengeluaran barang beserta barang keluar
        $pengeluaranBarang = PengeluaranBarang::with('barangKeluar')->findOrFail($pengeluaranId);

        // Mengambil informasi tambahan terkait pengeluaran barang (misal: User yang mengeluarkan barang)
        $approvalData = ApprovalBarangKeluar::with('user')
            ->where('pengeluaran_barang_id', $pengeluaranId)
            ->get()
            ->map(function ($approval, $index) {
                return [
                    'no' => $index + 1,
                    'nama' => $approval->user->name ?? 'Tidak Diketahui',
                    'tingkatan' => $approval->user->level ?? 'Tidak Diketahui',
                    'departemen' => $approval->user->departemen ?? 'Tidak Diketahui',
                    'status' => $approval->status_approval,
                ];
            });

        return response()->json([
            'barang_keluar' => $pengeluaranBarang->barangKeluar,
            'informasi_tambahan' => $approvalData,
            'status' => $pengeluaranBarang->status, // Tambahkan status pengeluaran
            'kategori_pengeluaran' => $pengeluaranBarang->kategori_pengeluaran,
        ], 200);
    }

    public function getDetailNonAuth(Request $request)
    {
        $pengeluaranId = $request->pengeluaran_barang_id;

        // Mengambil data pengeluaran barang beserta barang keluar
        $pengeluaranBarang = PengeluaranBarang::with('barangKeluar')->findOrFail($pengeluaranId);

        // Mengambil informasi tambahan terkait pengeluaran barang (misal: User yang mengeluarkan barang)
        $approvalData = ApprovalBarangKeluar::with('user')
            ->where('pengeluaran_barang_id', $pengeluaranId)
            ->get()
            ->map(function ($approval, $index) {
                return [
                    'no' => $index + 1,
                    'nama' => $approval->user->name ?? 'Tidak Diketahui',
                    'tingkatan' => $approval->user->level ?? 'Tidak Diketahui',
                    'departemen' => $approval->user->departemen ?? 'Tidak Diketahui',
                    'status' => $approval->status_approval,
                ];
            });

        return response()->json([
            'barang_keluar' => $pengeluaranBarang->barangKeluar,
            'informasi_tambahan' => $approvalData,
        ], 200);
    }


    private function generateSuratJalan($lokasi, $departemen)
    {
        // Ambil tahun dan bulan saat ini
        $tahun = now()->format('Y');
        $bulanAngka = now()->format('m');
        $bulanRomawi = $this->convertToRoman($bulanAngka);

        // Hitung nomor urut surat jalan untuk bulan dan tahun yang sama
        $lastNumber = DB::table('tb_pengeluaran_barang')
            ->whereYear('created_date', $tahun)
            ->whereMonth('created_date', $bulanAngka)
            ->count();

        $noSurat = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        // Gabungkan menjadi format surat jalan
        return "{$noSurat} / {$departemen} / {$lokasi} / {$bulanRomawi} / {$tahun}";
    }

    private function convertToRoman($month)
    {
        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        return $romans[intval($month)];
    }

    public function store(Request $request)
    {
        $request->validate([
            'created_by' => 'required',
            'kategori_pengeluaran' => 'required|in:0,1',
            'pembawa_scrap' => $request->kategori_pengeluaran == 1 ? 'required|string|max:35' : 'nullable',
            'tujuan_pengeluaran_barang' => 'required',
            'jenis_kendaraan' => 'required',
            'lokasi_barang_keluar' => 'required',
            'barang_ids' => 'required|array',
            'barang_ids.*' => 'required',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|numeric|min:1',
            'satuan' => 'required|array',
            'satuan.*' => 'required',
            'keterangan' => 'nullable|array',
        ]);
    
        $lokasiBarangKeluar = strtoupper($request->input('lokasi_barang_keluar'));
        $tujuanPengeluaran = strtoupper($request->input('tujuan_pengeluaran_barang'));
    
        if ($lokasiBarangKeluar === $tujuanPengeluaran) {
            return redirect()->back()->with('error', 'Lokasi barang keluar dan tujuan pengeluaran barang tidak boleh sama!')->withInput();
        }

        $nrpKaryawan = $request->input('created_by');
        $user = User::where('nrp_karyawan', $nrpKaryawan)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan!')->withInput();
        }
    
        DB::beginTransaction();
    
        try {

    
            $departemen = $user->departemen;
            $pengeluaranBarangId = $this->generateSuratJalan($request->input('lokasi_barang_keluar'), $departemen);
    
            // Insert ke tabel pengeluaran_barang
            $pengeluaranBarang = PengeluaranBarang::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'kategori_pengeluaran' => $request->kategori_pengeluaran,
                'pembawa_scrap' => $request->kategori_pengeluaran == 1 ? $request->pembawa_scrap : null,
                'tujuan_pengeluaran_barang' => $request->input('tujuan_pengeluaran_barang'),
                'jenis_kendaraan' => $request->input('jenis_kendaraan'),
                'lokasi_barang_keluar' => $request->input('lokasi_barang_keluar'),
                'status' => 'Level 1',
            ]);
    
            foreach ($request->input('barang_ids') as $index => $barangId) {
                $barangKeluar = BarangKeluar::create([
                    'nama_barang' => $barangId,
                    'jumlah_barang' => $request->input('jumlah')[$index],
                    'satuan_barang' => $request->input('satuan')[$index],
                    'keterangan_barang' => $request->input('keterangan')[$index],
                    'pengeluaran_barang_id' => $pengeluaranBarang->pengeluaran_barang_id, // Fix error
                ]);
            }
    
            // Insert ke tabel tb_approval
            ApprovalBarangKeluar::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'created_date' => now(),
                'status_approval' => 'Level 1',
            ]);
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    

    public function edit(Request $request)
    {
        $pengeluaranId = $request->pengeluaran_barang_id;
        $pengeluaranBarang = PengeluaranBarang::with('barangKeluar')->findOrFail($pengeluaranId);

        // Generate QR Code menggunakan BaconQrCode
        $renderer = new ImageRenderer(
            new RendererStyle(140), // Ukuran QR Code
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($pengeluaranBarang->pengeluaran_barang_id);

        return response()->json([
            'pengeluaran_barang_id'      => $pengeluaranBarang->pengeluaran_barang_id,
            'jenis_kendaraan'            => $pengeluaranBarang->jenis_kendaraan,
            'no_polisi'                  => $pengeluaranBarang->no_polisi,
            'status'                  => $pengeluaranBarang->status,
            'lokasi_barang_keluar'       => $pengeluaranBarang->lokasi_barang_keluar,
            'tujuan_pengeluaran_barang'  => $pengeluaranBarang->tujuan_pengeluaran_barang,
            'barangKeluar'               => $pengeluaranBarang->barangKeluar,
            'qr_code'                    => $qrCode
        ]);
    }

    public function update(Request $request) 
    {
        $data = $request->validate([
            'pengeluaran_barang_id'    => 'required',
            'jenis_kendaraan'          => 'required',
            'lokasi_barang_keluar'     => 'required',
            'tujuan_pengeluaran_barang'=> 'required',
            'barang_ids'               => 'required|array',
            'barang_ids.*'             => 'nullable|string',
            'nama_barang'              => 'required|array',
            'jumlah'                   => 'required|array',
            'satuan'                   => 'required|array',
            'keterangan'               => 'required|array',
        ]);
    
        DB::beginTransaction();
    
        $user = Auth::user();
        $nrpKaryawan = $user->nrp_karyawan;

        try {
            // Cari data pengeluaran barang berdasarkan ID
            $pengeluaranBarang = PengeluaranBarang::findOrFail($data['pengeluaran_barang_id']);
    
            // Update data utama di tabel tb_pengeluaran_barang
            $pengeluaranBarang->update([
                'jenis_kendaraan'       => $data['jenis_kendaraan'],
                'lokasi_barang_keluar'  => $data['lokasi_barang_keluar'],
                'tujuan_pengeluaran_barang' => $data['tujuan_pengeluaran_barang'],
                'updated_by'            => $nrpKaryawan, 
                'updated_date'          => now(),
            ]);
    
            // Ambil semua barang_keluar_id yang terkait dengan pengeluaran_barang_id ini dari tabel tb_barang_keluar
            $existingBarangIds = DB::table('tb_barang_keluar')
                ->where('pengeluaran_barang_id', $pengeluaranBarang->pengeluaran_barang_id)
                ->pluck('barang_keluar_id')
                ->toArray();
    
            // Barang yang tetap ada (dari form)
            $barangIdsFromForm = array_filter($data['barang_ids']);
    
            // Barang yang perlu dihapus
            $barangIdsToDelete = array_diff($existingBarangIds, $barangIdsFromForm);
    
            // Hapus barang dari database jika ada id yang tidak dipertahankan
            if (!empty($barangIdsToDelete)) {
                BarangKeluar::whereIn('barang_keluar_id', $barangIdsToDelete)->delete();
            }
    
            // Sinkronisasi dan proses insert/update barang
            foreach ($data['barang_ids'] as $index => $barangId) {
                // Jika barang ID kosong, buat record baru
                if (empty($barangId)) {
                    BarangKeluar::create([
                        // Jangan memasukkan 'barang_keluar_id' karena auto-increment
                        'pengeluaran_barang_id' => $pengeluaranBarang->pengeluaran_barang_id,
                        'nama_barang'           => $data['nama_barang'][$index],
                        'jumlah_barang'         => $data['jumlah'][$index],
                        'satuan_barang'         => $data['satuan'][$index],
                        'keterangan_barang'     => $data['keterangan'][$index],
                    ]);
                } else {
                    // Update barang yang sudah ada
                    $barang = BarangKeluar::findOrFail($barangId);
                    $barang->update([
                        'nama_barang'       => $data['nama_barang'][$index],
                        'jumlah_barang'     => $data['jumlah'][$index],
                        'satuan_barang'     => $data['satuan'][$index],
                        'keterangan_barang' => $data['keterangan'][$index],
                    ]);
                }
            }
    
            DB::commit();
    
            return redirect()->route('form')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
