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
    private function generateSuratJalan()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $dept = $user->departemen; // Kolom departemen dari tabel users
        $plant = 'P1'; // Plant diatur statis

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
        return "{$noSurat} / {$dept} / {$plant} / {$bulanRomawi} / {$tahun}";
    }

    // private function generateBarangKeluarId()
    // {
    //     // Ambil user yang sedang login
    //     $user = Auth::user();
    //     $dept = $user->departemen; // Kolom departemen dari tabel users
    //     $plant = 'P1'; // Plant diatur statis
    //     $bulanAngka = now()->format('m');
    //     $tahun = now()->format('Y');
    //     $bulanRomawi = $this->convertToRoman($bulanAngka); // Konversi bulan ke romawi

    //     // Cari nomor terbesar yang sudah ada untuk departemen ini
    //     $lastNumber = DB::table('tb_barang_keluar')
    //         ->where('barang_keluar_id', 'LIKE', 'BGKLR%' . $dept . '%')
    //         ->where('barang_keluar_id', 'LIKE', '%/' . $plant . '/%' . $bulanRomawi . '/' . $tahun)
    //         ->max(DB::raw('CAST(SUBSTRING(barang_keluar_id, 7, 4) AS UNSIGNED)'));

    //     // Tentukan nomor urut berikutnya
    //     $nextNumber = $lastNumber + 1;
    //     $barangKeluarId = 'BGKLR/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT) . '/' . $dept . '/' . $plant . '/' . $bulanRomawi . '/' . $tahun;

    //     return $barangKeluarId;
    // }
    // private function generateDetailPengeluaranId($index)
    // {
    //     // Ambil user yang sedang login
    //     $user = Auth::user();
    //     $dept = $user->departemen; // Kolom departemen dari tabel users
    //     $plant = 'P1'; // Plant diatur statis
    //     $bulanAngka = now()->format('m');
    //     $tahun = now()->format('Y');
    //     $bulanRomawi = $this->convertToRoman($bulanAngka); // Konversi bulan ke romawi

    //     // Cari nomor terbesar yang sudah ada untuk departemen ini
    //     $lastNumber = DB::table('tb_detail_pengeluaran')
    //         ->where('detail_pengeluaran_id', 'LIKE', 'DTPGL%' . $dept . '%')
    //         ->where('detail_pengeluaran_id', 'LIKE', '%/' . $plant . '/%' . $bulanRomawi . '/' . $tahun)
    //         ->max(DB::raw('CAST(SUBSTRING(detail_pengeluaran_id, 7, 5) AS UNSIGNED)'));

    //     // Tentukan nomor urut berikutnya
    //     $nextNumber = $lastNumber + 1;
    //     $detailPengeluaranId = 'DTPGL/' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT) . '/' . $dept . '/' . $plant . '/' . $bulanRomawi . '/' . $tahun;

    //     return $detailPengeluaranId;
    // }

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
            $pengeluaranBarangId = $this->generateSuratJalan();
    
            // Insert ke tabel pengeluaran_barang
            $pengeluaranBarang = PengeluaranBarang::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'tujuan_pengeluaran_barang' => $request->input('tujuan_pengeluaran_barang'),
                'jenis_kendaraan' => $request->input('jenis_kendaraan'),
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
                'status_approval' => 'Level 1',
            ]);
    
            DB::commit();
    
            return redirect()->route('form')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    

    
}
