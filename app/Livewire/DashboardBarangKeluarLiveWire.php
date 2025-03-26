<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PengeluaranBarang;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardBarangKeluarLiveWire extends Component
{
    public function render()
    {
        $user = Auth::user();
        $query = PengeluaranBarang::with(['user', 'approval', 'barangKeluar'])
        ->whereDate('created_date', Carbon::today()); // Hanya ambil data hari ini

        

        if ($user->level === 'Staff') {
            $pengeluaranBarangs = $query->where(function ($q) use ($user) {
                $q->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen);
                })->orWhere('created_by', $user->nrp_karyawan);
            })->get();
        } elseif ($user->level === 'Ka.Sie') {
            $pengeluaranBarangs = $query->whereHas('user', function ($query) use ($user) {
                $query->where('departemen', $user->departemen);
            })->get();
        } elseif ($user->level === 'Security' || $user->level === 'Ka.Dept' ) {
            $pengeluaranBarangs = $query->get();
        } else {
            $pengeluaranBarangs = collect();
        }
    
       // Ekstrak angka dari level user
        $userLevel = (int) filter_var($user->level, FILTER_SANITIZE_NUMBER_INT);

        // Mengambil data status yang disetujui (hanya dari data hari ini)
        $pengeluaranBarangsDisetujui = $pengeluaranBarangs->filter(fn ($item) => 
            (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === $userLevel || 
            (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) > $userLevel
        )->count();

        // Mengambil data status yang menunggu (hanya dari data hari ini)
        $pengeluaranBarangsMenunggu = $pengeluaranBarangs->filter(fn ($item) =>
            (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === ($userLevel - 1)
        )->count();

        // Mengambil data status yang ditolak (hanya dari data hari ini)
        $pengeluaranBarangsDitolak = $pengeluaranBarangs->filter(fn ($item) =>
            (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === 0
        )->count();

        // 📊 Data Harian (7 hari terakhir)
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        // Ambil data dari database
        $dailyDataQuery = PengeluaranBarang::selectRaw("DATE(created_date) as tanggal, COUNT(*) as jumlah")
            ->whereBetween('created_date', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get()
            ->keyBy('tanggal'); // Index berdasarkan tanggal

        // Generate semua tanggal dari 7 hari terakhir
        $period = CarbonPeriod::create($startDate, $endDate);
        $dailyData = [
            'labels' => [],
            'data' => [],
            'days' => []
        ];

        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            $dailyData['labels'][] = $formattedDate;
            $dailyData['days'][] = $date->translatedFormat('l'); // Nama hari
            $dailyData['data'][] = $dailyDataQuery[$formattedDate]->jumlah ?? 0; // Ambil jumlah atau set ke 0
        }

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

        // 📊 Data Pie Chart berdasarkan Departemen
        $pieQuery = PengeluaranBarang::pluck('pengeluaran_barang_id'); // Ambil hanya kolom ID
        $pieData = $pieQuery->map(function ($item) {
            $parts = explode(' / ', $item);
            return $parts[1] ?? null; // Ambil bagian kedua (Departemen)
        })->filter()->countBy()->toArray();

        return view('livewire.dashboard-notif-card', [
            'pengeluaranBarangs' => $pengeluaranBarangs,
            'pengeluaranBarangsDisetujui' => $pengeluaranBarangsDisetujui,
            'pengeluaranBarangsMenunggu' => $pengeluaranBarangsMenunggu,
            'pengeluaranBarangsDitolak' => $pengeluaranBarangsDitolak,
            'dailyData' => json_encode($dailyData),
            'monthlyData' => json_encode($monthlyData),
            'yearlyData' => json_encode($yearlyData),
            'pieData' => json_encode($pieData),
            'user' => $user
        ]);
    }

}
