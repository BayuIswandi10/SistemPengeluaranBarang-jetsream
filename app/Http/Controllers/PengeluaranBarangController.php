<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengeluaranBarang;
use App\Models\BarangKeluar;
use App\Models\Approval;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengeluaranBarangController extends Controller
{
    public function index()
    {
        $pengeluaranBarangs = PengeluaranBarang::with('approval')->get(); 
        return view('livewire.form-pengeluaran', compact('pengeluaranBarangs'));
    }

    public function getDetail($pengeluaranBarangId)
    {
        $pengeluaranBarang = PengeluaranBarang::with('barangKeluar')->findOrFail($pengeluaranBarangId);

        return response()->json([
            'pengeluaran_barang_id' => $pengeluaranBarang->pengeluaran_barang_id,
            'barangKeluar' => $pengeluaranBarang->barangKeluar->map(function ($barang) {
                return [
                    'nama_barang' => $barang->nama_barang,
                    'jumlah_barang' => $barang->jumlah_barang,
                    'satuan_barang' => $barang->satuan_barang,
                    'keterangan_barang' => $barang->keterangan_barang,
                ];
            }),
        ]);
    }


    private function generateSuratJalan($lokasi)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $dept = $user->departemen; // Kolom departemen dari tabel users

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
        return "{$noSurat} / {$dept} / {$lokasi} / {$bulanRomawi} / {$tahun}";
    }
    
    private function generateBarangKeluarId()
    {
        // Mendapatkan nomor terakhir
        $lastNumber = DB::table('tb_barang_keluar')
            ->max(DB::raw('CAST(SUBSTRING(barang_keluar_id, 4) AS UNSIGNED)'));

        // Jika belum ada ID, mulai dari BKL0001
        if (!$lastNumber) {
            return 'BKL0001';
        }

        // Increment nomor terakhir
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return 'BKL' . $newNumber;
    }

    private function generateDetailPengeluaranId()
    {
        // Mendapatkan nomor terakhir
        $lastNumber = DB::table('tb_detail_pengeluaran')
            ->max(DB::raw('CAST(SUBSTRING(detail_pengeluaran_id, 4) AS UNSIGNED)'));

        // Jika belum ada ID, mulai dari DTL0001
        if (!$lastNumber) {
            return 'DTL0001';
        }

        // Increment nomor terakhir
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return 'DTL' . $newNumber;
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
        DB::beginTransaction();
    
        try {
            $user = Auth::user();
            $nrpKaryawan = $user->nrp_karyawan;
    
            // Generate nomor surat jalan
            $pengeluaranBarangId = $this->generateSuratJalan($request->input('lokasi_barang_keluar'));
    
            // Insert ke tabel pengeluaran_barang
            $pengeluaranBarang = PengeluaranBarang::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'tujuan_pengeluaran_barang' => $request->input('tujuan_pengeluaran_barang'),
                'jenis_kendaraan' => $request->input('jenis_kendaraan'),
                'lokasi_barang_keluar' => $request->input('lokasi_barang_keluar'), // Simpan lokasi
                'status' => 'Level 0', // Set Level 0 saat pengeluaran dibuat
            ]);
    
            // Iterasi barang dan buat entry pada barang_keluar
            foreach ($request->input('barang_ids') as $index => $barangId) {
                // Generate barang_keluar_id secara otomatis
                $barangKeluarId = $this->generateBarangKeluarId();
    
                // Insert ke tabel barang_keluar
                $barangKeluar = BarangKeluar::create([
                    'barang_keluar_id' => $barangKeluarId,
                    'nama_barang' => $barangId,
                    'jumlah_barang' => $request->input('jumlah')[$index],
                    'satuan_barang' => $request->input('satuan')[$index],
                    'keterangan_barang' => $request->input('keterangan')[$index],
                ]);
    
                // Generate detail_pengeluaran_id
                $detailPengeluaranId = $this->generateDetailPengeluaranId($index);
    
                // Hubungkan dengan tabel pivot
                $pengeluaranBarang->barangKeluar()->attach($barangKeluar->barang_keluar_id, [
                    'detail_pengeluaran_id' => $detailPengeluaranId,
                ]);
            }
    
            // Generate approval_id dengan format APR0001 (hanya satu kali per pengeluaran_barang_id)
            $approvalId = $this->generateApprovalId();
    
            // Insert ke tabel tb_approval
            Approval::create([
                'approval_id' => $approvalId,
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'created_date' => now(),
                'status_approval' => 'Level 0',
            ]);
    
            DB::commit();
    
            return redirect()->route('form')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
            $approvalId = $this->generateApprovalId();
            $approval = Approval::create([
                'approval_id' => $approvalId,
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'status_approval' => 'Level 1',
                'created_date' => now(),
            ]);
    
            if (!$approval) {
                throw new \Exception('Gagal menambahkan data approval.');
            }
    
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


    public function update(Request $request)
    {
        $data = $request->validate([
            'pengeluaran_barang_id' => 'required',
            'jenis_kendaraan' => 'required',
            'lokasi_barang_keluar' => 'required',
            'tujuan_pengeluaran_barang' => 'required',
            'barang_ids' => 'required|array',
            'jumlah' => 'required|array',
            'satuan' => 'required|array',
            'keterangan' => 'required|array',
        ]);

        // Cari pengeluaran barang berdasarkan ID
        $pengeluaranBarang = PengeluaranBarang::findOrFail($data['pengeluaran_barang_id']);
        $pengeluaranBarang->update([
            'jenis_kendaraan' => $data['jenis_kendaraan'],
            'lokasi_barang_keluar' => $data['lokasi_barang_keluar'],
            'tujuan_pengeluaran_barang' => $data['tujuan_pengeluaran_barang'],
        ]);

        // Update detail barang keluar
        foreach ($data['barang_ids'] as $index => $barangId) {
            $barang = $pengeluaranBarang->barangKeluar[$index];
            $barang->update([
                'nama_barang' => $data['barang_ids'][$index],
                'jumlah_barang' => $data['jumlah'][$index],
                'satuan_barang' => $data['satuan'][$index],
                'keterangan_barang' => $data['keterangan'][$index],
            ]);
        }

        return redirect()->route('form')->with('success', 'Data berhasil diperbarui');
    }    
}
