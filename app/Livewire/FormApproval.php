<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PengeluaranBarang;
use Illuminate\Support\Facades\Auth;

class FormApproval extends Component
{
    public function render()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $query = PengeluaranBarang::with(['user', 'approval', 'barangKeluar']); // Relasi
    
        // Filter data berdasarkan level user
        if ($user->level === 'Staff') {
            // Data yang dapat dilihat: Pengeluaran dari departemennya sendiri atau yang dibuat oleh dirinya sendiri
            $pengeluaranBarangs = $query->where(function ($q) use ($user) {
                $q->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen); // Departemen user
                })->orWhere('created_by', $user->nrp_karyawan); // Dibuat oleh user
            })->get();
        } elseif ($user->level === 'Ka.Sie') {
            // Data yang dapat dilihat: Pengeluaran dari departemennya sendiri
            $pengeluaranBarangs = $query->whereHas('user', function ($query) use ($user) {
                $query->where('departemen', $user->departemen);
            })->get();
        } elseif ($user->level === 'Ka.Dept' && $user->departemen !== 'GA') {
            // Data default: Pengeluaran dari departemennya sendiri
            $pengeluaranBarangs = $query->whereHas('user', function ($query) use ($user) {
                $query->where('departemen', $user->departemen);
            })->get();
    
            // Jika mencari data dari seluruh departemen (opsional, tergantung permintaan)
            if (request()->has('cari_departemen')) {
                $pengeluaranBarangs = $query->get(); // Lihat semua departemen
            }
        } elseif ($user->level === 'Ka.Dept' && $user->departemen === 'GA') {
            // Data yang dapat dilihat: Semua pengeluaran dari seluruh departemen
            $pengeluaranBarangs = $query->get();
        } elseif ($user->departemen === 'FIN') {
            // Hanya melihat data dengan status "Level 4" dan kategori_pengeluaran = 1 (Scrap)
            $pengeluaranBarangs = $query->where('status', 'Level 4')
                ->where('kategori_pengeluaran', 1)->get();
        } else {
            // Jika level tidak dikenali, tampilkan data kosong
            $pengeluaranBarangs = collect();
        }    

        return view('livewire.form-approval', compact('pengeluaranBarangs','user')); 
    }


}
