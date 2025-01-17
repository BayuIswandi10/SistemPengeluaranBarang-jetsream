<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PengeluaranBarang;

class FormPengeluaran extends Component
{
    public $pengeluaranBarangId; // Menyimpan nomor surat jalan

    public function mount()
    {
        $this->generateSuratJalan(); // Panggil fungsi untuk generate no surat jalan
    }

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
        $this->pengeluaranBarangId = "{$noSurat} / {$dept} / {$plant} / {$bulanRomawi} / {$tahun}";
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
        $pengeluaranBarangs = PengeluaranBarang::with(['approval', 'barangKeluar'])->get(); 
        return view('livewire.form-pengeluaran', compact('pengeluaranBarangs'));
    }

}
