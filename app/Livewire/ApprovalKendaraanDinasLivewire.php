<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SuratKendaraanDinas;
use Illuminate\Support\Facades\Auth;

class ApprovalKendaraanDinasLivewire extends Component
{
    public function render()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $query = SuratKendaraanDinas::with(['user', 'approval', 'pencatatanKendaraanDinas']); // Relasi

        if ($user->level === 'Ka.Dept' && $user->departemen !== 'General Affairs') {
            // Data default: Pengeluaran dari departemennya sendiri
            $kendaraanDinas = (clone $query)->whereHas('user', function ($query) use ($user) {
                $query->where('departemen', $user->departemen);
            })
            ->orderBy('status', 'asc') // Level 1 paling atas
            ->get();
        } elseif ($user->level === 'Ka.Dept' && $user->departemen === 'General Affairs') {
            // Data yang dapat dilihat: Semua pengeluaran dari seluruh departemen
            $kendaraanDinas = (clone $query)
            ->orderBy('status', 'asc')
            ->get();
        }elseif ($user->level === 'Ka.Sie' && $user->departemen === 'General Affairs') {
            // Data yang dapat dilihat: Semua pengeluaran dari seluruh departemen
            $kendaraanDinas = (clone $query)
            ->orderBy('status', 'asc')
            ->get();
        } else {
            // Jika level tidak dikenali, tampilkan data kosong
            $kendaraanDinas = collect();
        }  

        return view('livewire.approval-kendaraan-dinas-livewire', compact('kendaraanDinas', 'user'));
    }
}
