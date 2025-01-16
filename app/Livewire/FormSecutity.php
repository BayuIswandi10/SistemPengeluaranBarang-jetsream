<?php

namespace App\Livewire;
use App\Models\Approval;
use Livewire\Component;

class FormSecutity extends Component
{
    // Livewire Component
    public function render()
    {
        // Ambil data approvals dan barang terkait
        $approvals = Approval::with(['pengeluaranBarang.barangKeluar'])->get();
        
        // Mengumpulkan semua barang yang ada dalam pengeluaranBarang
        $barangDetails = [];
        foreach ($approvals as $approval) {
            foreach ($approval->pengeluaranBarang->barangKeluar as $barang) {
                $barangDetails[] = (object) [
                    'pengeluaran_barang_id' => $approval->pengeluaranBarang->pengeluaran_barang_id,
                    'nama_barang' => $barang->nama_barang,
                    'jumlah_barang' => $barang->jumlah_barang,
                    'satuan_barang' => $barang->satuan_barang,
                    'keterangan_barang' => $barang->keterangan_barang,
                ];
            }
        }
        
        return view('livewire.form-secutity', compact('approvals', 'barangDetails'));
    }

}
