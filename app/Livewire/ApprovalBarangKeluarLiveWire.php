<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PengeluaranBarang;
use Illuminate\Support\Facades\Auth;

class ApprovalBarangKeluarLiveWire extends Component
{
    public function render()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $query = PengeluaranBarang::with(['user', 'approval', 'barangKeluar']); // Relasi
    
        // Jika user berasal dari departemen FIN (apapun levelnya)
        if ($user->departemen === 'Finance') {
            $pengeluaranBarangs = (clone $query)
                // ->where('status', 'Level 4')
                ->where('kategori_pengeluaran', 1)
                ->orderBy('status', 'asc')
                ->get();
        } elseif ($user->level === 'Staff') {
            // Data yang dapat dilihat: Pengeluaran dari departemennya sendiri atau yang dibuat oleh dirinya sendiri
            $pengeluaranBarangs = (clone $query)->where(function ($q) use ($user) {
                $q->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen); // Departemen user
                })->orWhere('created_by', $user->nrp_karyawan); // Dibuat oleh user
            })->get();
        } elseif ($user->level === 'Ka.Sie') {
            // Data yang dapat dilihat: Pengeluaran dari departemennya sendiri
            $pengeluaranBarangs = (clone $query)->whereHas('user', function ($query) use ($user) {
                $query->where('departemen', $user->departemen);
            })
            ->orderBy('status', 'asc')
            ->get();
        } elseif ($user->level === 'Ka.Dept' && $user->departemen !== 'General Affairs') {
            // Data default: Pengeluaran dari departemennya sendiri
            $pengeluaranBarangs = (clone $query)->whereHas('user', function ($query) use ($user) {
                $query->where('departemen', $user->departemen);
            })
            ->orderBy('status', 'asc') // Level 1 paling atas
            ->get();
    
            // Jika mencari data dari seluruh departemen (opsional, tergantung permintaan)
            if (request()->has('cari_departemen')) {
                $pengeluaranBarangs = (clone $query)->get(); // Lihat semua departemen
            }
        } elseif ($user->level === 'Ka.Dept' && $user->departemen === 'General Affairs') {
            // Data yang dapat dilihat: Semua pengeluaran dari seluruh departemen
            $pengeluaranBarangs = (clone $query)
            ->orderBy('status', 'asc')
            ->get();
        } else {
            // Jika level tidak dikenali, tampilkan data kosong
            $pengeluaranBarangs = collect();
        }    

        return view('livewire.form-approval', compact('pengeluaranBarangs', 'user')); 
    }
}