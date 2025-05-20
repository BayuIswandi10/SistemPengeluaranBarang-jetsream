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
                ->orderByRaw("FIELD(status, 'Level 4') DESC")
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
            ->orderByRaw("FIELD(status, 'Level 1') DESC")
            ->orderBy('status', 'asc')
            ->get();
        } elseif ($user->level === 'Ka.Dept' && $user->departemen !== 'General Affairs') {
            // Ambil semua data terlebih dahulu
            $pengeluaranBarangs = (clone $query)->with('user')->orderByRaw("FIELD(status, 'Level 2') DESC")->get();
        
            // Sorting lokal: departemen user tampil di atas
            $pengeluaranBarangs = $pengeluaranBarangs->sortByDesc(function ($item) use ($user) {
                return $item->user->departemen === $user->departemen ? 1 : 0;
            })->values(); // values() untuk reset index array
        }
         elseif ($user->level === 'Ka.Dept' && $user->departemen === 'General Affairs') {
            // Level 2 untuk pengajuan dari GA sendiri
            $level2FromGA = (clone $query)
                ->where('status', 'Level 2')
                ->whereHas('user', function ($q) {
                    $q->where('departemen', 'General Affairs');
                })
                ->get();

            // Semua data lain, Level 3 diprioritaskan
            $others = (clone $query)
                ->where(function ($q) {
                    $q->where('status', '!=', 'Level 2')
                    ->orWhereHas('user', function ($q2) {
                        $q2->where('departemen', '!=', 'General Affairs');
                    });
                })
                ->orderByRaw("FIELD(status, 'Level 3') DESC")
                ->orderBy('status', 'asc')
                ->get();

            // Gabungkan koleksi
            $pengeluaranBarangs = $level2FromGA->concat($others);
        } else {
            // Jika level tidak dikenali, tampilkan data kosong
            $pengeluaranBarangs = collect();
        }    

        return view('livewire.form-approval', compact('pengeluaranBarangs', 'user')); 
    }
}