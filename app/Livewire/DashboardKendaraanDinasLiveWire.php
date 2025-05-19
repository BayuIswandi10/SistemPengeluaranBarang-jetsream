<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SuratKendaraanDinas;
use App\Models\SuratKendaraanDinasDetail;
use App\Models\ApprovalKendaraanDinas;
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
        $startOfDay = Carbon::today()->startOfDay(); // 2025-05-06 00:00:00
        $endOfDay = Carbon::today()->endOfDay(); // 2025-05-06 23:59:59
        $query = SuratKendaraanDinas::with(['user', 'approval'])
        ->whereBetween('created_date', [$startOfDay, $endOfDay]);
        

        // Filter data berdasarkan level user
        if ($user->level === 'Ka.Sie' && $user->seksi !== 'General Service') {
            // Ka.Sie biasa → hanya data dari departemen yang sama
            $suratKendaraanDinasList = $query->whereHas('user', function ($query) use ($user) {
                $query->where('departemen', $user->departemen);
            })->get();

        } elseif (
            in_array($user->level, ['Ka.Dept', 'Security', 'Super Admin']) ||
            ($user->level === 'Ka.Sie' && $user->seksi === 'General Service')
        ) {
            // Ka.Sie dengan seksi General Service → dapat semua data
            $suratKendaraanDinasList = $query->get();

        } else {
            // Selain itu, kosong
            $suratKendaraanDinasList = collect();
        }

        // Ekstrak angka dari level user
        if ($user->level === 'Ka.Dept') {
            $userLevel = 2;
        } elseif ($user->level === 'Ka.Sie' && $user->departemen === 'General Affairs') {
            $userLevel = 3;
        } elseif ($user->level === 'Security') {
            $userLevel = 4;
        }

        $approvedIdsByUser = ApprovalKendaraanDinas::where('created_by', $user->nrp_karyawan)
        ->where('status_approval', '!=', 'Level 0')
        ->pluck('surat_kendaraan_dinas_id')
        ->toArray();
        $suratDisetujui = $suratKendaraanDinasList->filter(function ($item) use ($approvedIdsByUser) {
            return in_array($item->surat_kendaraan_dinas_id, $approvedIdsByUser);
        })->count();

        $suratMenunggu = $suratKendaraanDinasList->filter(fn ($item) =>
            (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === ($userLevel - 1)
        )->count();

        $rejectedIdsByUser = ApprovalKendaraanDinas::where('created_by', $user->nrp_karyawan)
        ->where('status_approval', 'Level 0')
        ->pluck('surat_kendaraan_dinas_id')
        ->toArray();
        $suratDitolak = $suratKendaraanDinasList->filter(function ($item) use ($rejectedIdsByUser) {
            return in_array($item->surat_kendaraan_dinas_id, $rejectedIdsByUser);
        })->count();

        $start = Carbon::today()->startOfDay();
        $end = Carbon::today()->endOfDay();

        // 1. Ambil semua surat kendaraan dinas dalam rentang tanggal
        $suratIds = SuratKendaraanDinas::whereBetween('created_date', [$start, $end])
            ->pluck('surat_kendaraan_dinas_id');

        // 2. Ambil detail surat berdasarkan ID surat
        $detailSurat = SuratKendaraanDinasDetail::whereIn('surat_kendaraan_dinas_id', $suratIds)->get();

        // 3. Ambil kendaraan_dinas_id yang terlibat
        $kendaraanDigunakanIds = $detailSurat->pluck('kendaraan_dinas_id')->unique();

        // 4. Ambil semua kendaraan dinas
        $kendaraanDinasAll = KendaraanDinas::all();

        // Filter kendaraan jenis_kendaraan == 1
        $filteredKendaraanDinas = $kendaraanDinasAll->where('jenis_kendaraan', 1);

        // Kendaraan yang sedang digunakan dan jenis_kendaraan == 1
        $kendaraanDinasSedangDigunakan = $filteredKendaraanDinas
            ->whereIn('kendaraan_dinas_id', $kendaraanDigunakanIds)
            ->count();

        // Kendaraan yang tersedia dan jenis_kendaraan == 1
        $kendaraanDinasTersedia = $filteredKendaraanDinas
            ->whereNotIn('kendaraan_dinas_id', $kendaraanDigunakanIds)
            ->count();

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
        $labelMap = [
            'KN' => 'Kantor',
            'PR' => 'Pribadi',
            'TX' => 'Taxi',
        ];
        
        $pieData = SuratKendaraanDinas::pluck('surat_kendaraan_dinas_id')
            ->map(fn($id) => explode('/', $id)[0] ?? null)
            ->filter()
            ->countBy()
            ->mapWithKeys(function ($count, $key) use ($labelMap) {
                $label = $labelMap[$key] ?? $key; // fallback ke key asli kalau gak ada di map
                return [$label => $count];
            })
            ->toArray();
        

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
