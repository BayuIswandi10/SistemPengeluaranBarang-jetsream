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

       // Filter data berdasarkan level user
       if (in_array($user->level, ['Ka.Sie']) && $user->seksi !== 'General Service') {
                // Ka.Sie dan Ka.Dept biasa → hanya data dari departemen yang sama
                $kendaraanDinas = $query->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen);
                })->get();
            }
        elseif (
            in_array($user->level, ['Ka.Dept', 'Security', 'Super Admin']) ||
            ($user->level === 'Ka.Sie' && $user->seksi === 'General Service')
        ) {
            // Ka.Sie dengan seksi General Service → dapat semua data
            $kendaraanDinas = $query->orderByRaw("FIELD(status, 'Level 2') DESC")->get();

        } else {
            // Selain itu, kosong
            $kendaraanDinas = collect();
        }

        return view('livewire.approval-kendaraan-dinas-livewire', compact('kendaraanDinas', 'user'));
    }
}
