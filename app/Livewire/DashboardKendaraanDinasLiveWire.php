<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SuratKendaraanDinas;
use App\Models\KendaraanDinas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardKendaraanDinasLiveWire extends Component
{
    public function render()
    {
        
        $user = Auth::user();
        $user->level = trim($user->level);
        $query = SuratKendaraanDinas::with(['user', 'approval'])
            ->whereDate('created_date', Carbon::today());
        
        $kendaraanDinas = collect();

        if ($user->level === 'Staff') {
            $suratKendaraanDinasList = $query->where(function ($q) use ($user) {
                $q->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen);
                })->orWhere('created_by', $user->nrp_karyawan);
            })->get();
        } elseif ($user->level === 'Ka.Sie') {
            $suratKendaraanDinasList = $query->whereHas('user', function ($query) use ($user) {
                $query->where('departemen', $user->departemen);
            })->get();
        } elseif (in_array($user->level, ['Security', 'Ka.Dept', 'Super Admin'])) {
            $suratKendaraanDinasList = $query->get();
            $kendaraanDinas = KendaraanDinas::all();
        } else {
            $suratKendaraanDinasList = collect();
        }

        $userLevel = (int) filter_var($user->level, FILTER_SANITIZE_NUMBER_INT);

        $suratDisetujui = $suratKendaraanDinasList->filter(fn ($item) =>
            (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === $userLevel ||
            (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) > $userLevel
        )->count();

        $suratMenunggu = $suratKendaraanDinasList->filter(fn ($item) =>
            (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === ($userLevel - 1)
        )->count();

        $suratDitolak = $suratKendaraanDinasList->filter(fn ($item) =>
            (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === 0
        )->count();

        $kendaraanDinasTersedia = $kendaraanDinas->filter(fn($item) => $item->status_kendaraan == 1)->count();

        $kendaraanDinasSedangDigunakan = $kendaraanDinas->filter(fn($item) => $item->status_kendaraan == 2)->count();

        // 📊 Data Harian (7 hari terakhir)
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $dailyDataQuery = SuratKendaraanDinas::selectRaw("DATE(created_date) as tanggal, COUNT(*) as jumlah")
            ->whereBetween('created_date', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get()
            ->keyBy('tanggal');

        $period = CarbonPeriod::create($startDate, $endDate);
        $dailyData = [
            'labels' => [],
            'data' => [],
            'days' => []
        ];

        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            $dailyData['labels'][] = $formattedDate;
            $dailyData['days'][] = $date->translatedFormat('l');
            $dailyData['data'][] = $dailyDataQuery[$formattedDate]->jumlah ?? 0;
        }

        // 📊 Data Bulanan (12 bulan terakhir)
        $monthlyDataQuery = SuratKendaraanDinas::selectRaw("DATE_FORMAT(created_date, '%Y-%m') as bulan, COUNT(*) as jumlah")
            ->whereBetween('created_date', [now()->subMonths(11)->startOfMonth(), now()->endOfMonth()])
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        $monthlyData = [
            'labels' => $monthlyDataQuery->pluck('bulan')->toArray(),
            'data' => $monthlyDataQuery->pluck('jumlah')->toArray()
        ];

        // 📊 Data Tahunan (5 tahun terakhir)
        $yearlyDataQuery = SuratKendaraanDinas::selectRaw("YEAR(created_date) as tahun, COUNT(*) as jumlah")
            ->whereBetween('created_date', [now()->subYears(4)->startOfYear(), now()->endOfYear()])
            ->groupBy('tahun')
            ->orderBy('tahun', 'asc')
            ->get();

        $yearlyData = [
            'labels' => $yearlyDataQuery->pluck('tahun')->toArray(),
            'data' => $yearlyDataQuery->pluck('jumlah')->toArray()
        ];

        // 📊 Pie Chart Berdasarkan Departemen
        $pieQuery = SuratKendaraanDinas::pluck('surat_kendaraan_dinas_id');
        $pieData = $pieQuery->map(function ($item) {
            $parts = explode(' / ', $item);
            return $parts[1] ?? null;
        })->filter()->countBy()->toArray();

        return view('livewire.dashboard-kendaraan-dinas', [
            'suratKendaraanDinas' => $suratKendaraanDinasList,
            'suratDisetujui' => $suratDisetujui,
            'suratMenunggu' => $suratMenunggu,
            'suratDitolak' => $suratDitolak,
            'kendaraanDinasSedangDigunakan' => $kendaraanDinasSedangDigunakan,
            'kendaraanDinasTersedia' => $kendaraanDinasTersedia,
            'dailyData' => json_encode($dailyData),
            'monthlyData' => json_encode($monthlyData),
            'yearlyData' => json_encode($yearlyData),
            'pieData' => json_encode($pieData),
            'user' => $user
        ]);
    }
}
