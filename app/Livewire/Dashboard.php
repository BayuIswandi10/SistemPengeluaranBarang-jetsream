<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PengeluaranBarang;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        $query = PengeluaranBarang::with(['user', 'approval', 'barangKeluar']);
    
        if ($user->level === 'Level 1') {
            $pengeluaranBarangs = $query->where(function ($q) use ($user) {
                $q->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen);
                })->orWhere('created_by', $user->nrp_karyawan);
            })->get();
        } elseif ($user->level === 'Level 2' || $user->level === 'Level 3') {
            $pengeluaranBarangs = $query->whereHas('user', function ($query) use ($user) {
                $query->where('departemen', $user->departemen);
            })->get();
        } elseif ($user->level === 'Level 4') {
            $pengeluaranBarangs = $query->get();
        } else {
            $pengeluaranBarangs = collect();
        }
    
        // Menghitung jumlah yang sudah disetujui dan yang masih menunggu
        $pengeluaranBarangsDisetujui = $pengeluaranBarangs->filter(fn ($item) => $item->status !== $user->level)->count();
        $pengeluaranBarangsMenunggu = $pengeluaranBarangs->filter(fn ($item) => $item->status === $user->level)->count();

        // 📊 Data Harian (7 hari terakhir)
        $dailyDataQuery = PengeluaranBarang::selectRaw("DATE(created_date) as tanggal, COUNT(*) as jumlah")
            ->whereBetween('created_date', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $dailyData = [
            'labels' => $dailyDataQuery->pluck('tanggal')->toArray(),
            'data' => $dailyDataQuery->pluck('jumlah')->toArray()
        ];
    
        // 📊 Data Bulanan (12 bulan terakhir)
        $monthlyDataQuery = PengeluaranBarang::selectRaw("DATE_FORMAT(created_date, '%Y-%m') as bulan, COUNT(*) as jumlah")
            ->whereBetween('created_date', [now()->subMonths(11)->startOfMonth(), now()->endOfMonth()])
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        $monthlyData = [
            'labels' => $monthlyDataQuery->pluck('bulan')->toArray(),
            'data' => $monthlyDataQuery->pluck('jumlah')->toArray()
        ];

        // 📊 Data Tahunan (5 tahun terakhir)
        $yearlyDataQuery = PengeluaranBarang::selectRaw("YEAR(created_date) as tahun, COUNT(*) as jumlah")
            ->whereBetween('created_date', [now()->subYears(4)->startOfYear(), now()->endOfYear()])
            ->groupBy('tahun')
            ->orderBy('tahun', 'asc')
            ->get();

        $yearlyData = [
            'labels' => $yearlyDataQuery->pluck('tahun')->toArray(),
            'data' => $yearlyDataQuery->pluck('jumlah')->toArray()
        ];

        return view('livewire.dashboard-notif-card', [
            'pengeluaranBarangs' => $pengeluaranBarangs,
            'pengeluaranBarangsDisetujui' => $pengeluaranBarangsDisetujui,
            'pengeluaranBarangsMenunggu' => $pengeluaranBarangsMenunggu,
            'dailyData' => json_encode($dailyData),
            'monthlyData' => json_encode($monthlyData),
            'yearlyData' => json_encode($yearlyData),
            'user' => $user
        ]);
    }
}
