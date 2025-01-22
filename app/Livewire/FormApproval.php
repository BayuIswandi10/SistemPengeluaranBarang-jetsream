<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PengeluaranBarang;
use Illuminate\Support\Facades\Auth;

class FormApproval extends Component
{

    // public function render()
    // {
    //     $pengeluaranBarangs = PengeluaranBarang::with(['approval', 'barangKeluar'])->get(); 
    //     return view('livewire.form-approval', compact('pengeluaranBarangs'));
        
    // }

    // public function render()
    // {
    //     $user = Auth::user(); // Dapatkan user yang login
    //     $query = PengeluaranBarang::with(['user', 'approval', 'barangKeluar']);

    //     // Filter data berdasarkan level user
    //     if ($user->level === 'Level 1') {
    //         // Lihat data dengan status Level 1 dari departemen user atau yang dibuat oleh dirinya sendiri
    //         $pengeluaranBarangs = $query->where('status', 'Level 1')
    //             ->where(function ($q) use ($user) {
    //                 $q->whereHas('user', function ($query) use ($user) {
    //                     $query->where('departemen', $user->departemen); // Filter berdasarkan departemen
    //                 })->orWhere('created_by', $user->nrp_karyawan); // Filter berdasarkan user
    //             })
    //             ->get();
    //     } elseif ($user->level === 'Level 2') {
    //         // Lihat data dengan status Level 1 dari departemen user
    //         $pengeluaranBarangs = $query->where('status', 'Level 1')
    //             ->whereHas('user', function ($query) use ($user) {
    //                 $query->where('departemen', $user->departemen); // Filter berdasarkan departemen
    //             })
    //             ->get();
    //     } elseif ($user->level === 'Level 3') {
    //         // Default: Lihat data dengan status Level 2 dari departemen user
    //         $pengeluaranBarangs = $query->where('status', 'Level 2')
    //             ->whereHas('user', function ($query) use ($user) {
    //                 $query->where('departemen', $user->departemen);
    //             })
    //             ->get();
    //     } elseif ($user->level === 'Level 4') {
    //         // Lihat semua data dengan status Level 3
    //         $pengeluaranBarangs = $query->where('status', 'Level 3')->get();
    //     } else {
    //         // Jika level tidak dikenali, tampilkan data kosong
    //         $pengeluaranBarangs = collect();
    //     }

    //     return view('livewire.form-approval', compact('pengeluaranBarangs'));
    // }

    public function render()
    {
        $user = Auth::user(); // Dapatkan user yang login
        $query = PengeluaranBarang::with(['user', 'approval', 'barangKeluar']);

        // Filter data berdasarkan level user
        if ($user->level === 'Level 1') {
            // Lihat data dengan status Level 1 dari departemen user atau yang dibuat oleh dirinya sendiri
            $pengeluaranBarangs = $query->where('status', 'Level 1')
                ->where(function ($q) use ($user) {
                    $q->whereHas('user', function ($query) use ($user) {
                        $query->where('departemen', $user->departemen); // Filter berdasarkan departemen
                    })->orWhere('created_by', $user->nrp_karyawan); // Filter berdasarkan user
                })
                ->get();
        } elseif ($user->level === 'Level 2') {
            // Lihat data dengan status Level 1 dari departemen user
            $pengeluaranBarangs = $query->where('status', 'Level 1')
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen); // Filter berdasarkan departemen
                })
                ->get();
        } elseif ($user->level === 'Level 3') {
            // Lihat data dengan status Level 2 dari departemen user
            $pengeluaranBarangs = $query->where('status', 'Level 2')
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen); // Filter berdasarkan departemen
                })
                ->get();
        } elseif ($user->level === 'Level 4') {
            // Lihat semua data dengan status Level 3
            $pengeluaranBarangs = $query->where('status', 'Level 3')->get();
        } else {
            // Jika level tidak dikenali, tampilkan data kosong
            $pengeluaranBarangs = collect();
        }

        return view('livewire.form-approval', compact('pengeluaranBarangs','user')); 
    }



}
