<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PengeluaranBarang;
use Illuminate\Http\Request;

class PengeluaranBarangLiveWire extends Component
{
    public $pengeluaranBarangId; // Menyimpan nomor surat jalan

    public function mount(Request $request)
    {
        // Ambil lokasi_barang_keluar dari request
        $plant = $request->input('lokasi_barang_keluar', 'P1'); // Default 'P1' jika tidak ada input
        $this->generateSuratJalan($plant);
    }
    

    private function generateSuratJalan($plant)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $dept = $user->singkatan; // Kolom singkatan departemen dari tabel users
    
        // Ambil tahun dan bulan saat ini
        $tahun = now()->format('Y');
        $bulanAngka = now()->format('m');
        $bulanRomawi = $this->convertToRoman($bulanAngka);
    
        // Hitung nomor urut surat jalan untuk bulan dan tahun yang sama
        $lastNumber = DB::table('tb_pencatatan_pengeluaran_barang')
            ->whereYear('created_date', $tahun)
            ->whereMonth('created_date', $bulanAngka)
            ->count();
    
        $noSurat = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    
        // Gabungkan menjadi format surat jalan
        $this->pengeluaranBarangId = "{$noSurat}/{$dept}/{$plant}/{$bulanRomawi}/{$tahun}";
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

    public function render()
    {
                // Ambil data pengeluaran barang beserta approval dan barang terkait
                $pengeluaranBarangs = PengeluaranBarang::with(['approval', 'barangKeluar'])->get();
        
                // Mengumpulkan semua barang yang ada dalam pengeluaranBarang
                $barangDetails = [];
                foreach ($pengeluaranBarangs as $pengeluaranBarang) {
                    foreach ($pengeluaranBarang->barangKeluar as $barang) {
                        $barangDetails[] = (object) [
                            'pengeluaran_barang_id' => $pengeluaranBarang->pengeluaran_barang_id,
                            'nama_barang' => $barang->nama_barang,
                            'jumlah_barang' => $barang->jumlah_barang,
                            'satuan_barang' => $barang->satuan_barang,
                            'keterangan_barang' => $barang->keterangan_barang,
                        ];
                    }
                }
        
        return view('livewire.form-pengeluaran', compact('pengeluaranBarangs', 'barangDetails'));
    }

}
