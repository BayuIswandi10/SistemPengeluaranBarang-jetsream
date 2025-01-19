<?php

namespace App\Livewire;

use App\Models\PengeluaranBarang;
use Livewire\Component;

class FormSecutity extends Component
{
    // Livewire Component
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

        // Kirim data ke view
        return view('livewire.form-secutity', compact('pengeluaranBarangs', 'barangDetails'));
    }
}
