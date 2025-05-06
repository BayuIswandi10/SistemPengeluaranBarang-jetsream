<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PengeluaranBarang;
use App\Models\ApprovalBarangKeluar;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardBarangKeluarLiveWire extends Component
{
    public function render()
    {
        $user = Auth::user();
        $user->level = trim($user->level);
        $startOfDay = Carbon::today()->startOfDay(); // 2025-05-06 00:00:00
        $endOfDay = Carbon::today()->endOfDay(); // 2025-05-06 23:59:59

        $query = PengeluaranBarang::with(['user', 'approval', 'barangKeluar'])
            ->whereBetween('created_date', [$startOfDay, $endOfDay]);

            

         // Filter data berdasarkan level user
         if ($user->level === 'Staff' && $user->departemen === 'FIN') {
            $pengeluaranBarangs = $query->get();
        } elseif ($user->level === 'Ka.Sie') {
            $pengeluaranBarangs = $query->whereHas('user', function ($query) use ($user) {
                $query->where('departemen', $user->departemen);
            })->get();
        } elseif (in_array($user->level, ['Ka.Dept', 'Security', 'Super Admin'])) {
            $pengeluaranBarangs = $query->get();
        } 
        else {
            $pengeluaranBarangs = collect(); // Jika level tidak dikenali, kembalikan data kosong
        }
    
        // Ekstrak angka dari level user
        if ($user->level === 'Ka.Sie') {
            $userLevel = 2;
        } elseif ($user->level === 'Ka.Dept' && $user->departemen === 'General Affairs') {
            $userLevel = 4;
        } elseif ($user->level === 'Ka.Dept') {
            $userLevel = 3;
        } elseif ($user->level === 'Staff' && $user->departemen === 'Finance') {
            $userLevel = 5;
        } elseif ($user->level === 'Security') {
            $userLevel = 6;
        } elseif ($user->level === 'Super Admin') {
            $userLevel = 7;
        } else {
            $userLevel = 1; // default fallback jika tidak dikenali
        }
        
        // Mengambil data status yang disetujui (hanya dari data hari ini)
        $approvedIdsByUser = ApprovalBarangKeluar::where('created_by', $user->nrp_karyawan)
        ->where('status_approval', '!=', 'Level 0')
        ->pluck('pengeluaran_barang_id')
        ->toArray();

        $pengeluaranBarangsDisetujui = $pengeluaranBarangs
            ->filter(fn ($item) =>
                in_array($item->pengeluaran_barang_id, $approvedIdsByUser)
            )
            ->count();

        // Mengambil data status yang menunggu (hanya dari data hari ini)
        $pengeluaranBarangsMenunggu = $pengeluaranBarangs->filter(fn ($item) =>
            (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === ($userLevel - 1)
        )->count();

        // Mengambil data status yang ditolak (hanya dari data hari ini)
        $rejectedIdsByUser = ApprovalBarangKeluar::where('created_by', $user->nrp_karyawan)
        ->where('status_approval', 'Level 0')
        ->pluck('pengeluaran_barang_id')
        ->toArray();

        $pengeluaranBarangsDitolak = $pengeluaranBarangs
            ->filter(fn ($item) =>
                in_array($item->pengeluaran_barang_id, $rejectedIdsByUser)
            )
            ->count();

        // 📊 Data Harian (7 hari terakhir)
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();
        $period = CarbonPeriod::create($startDate, $endDate);

        $dailyQuery = PengeluaranBarang::selectRaw("DATE(created_date) as tanggal, kategori_pengeluaran, COUNT(*) as jumlah")
            ->whereBetween('created_date', [$startDate, $endDate])
            ->groupBy('tanggal', 'kategori_pengeluaran')
            ->orderBy('tanggal', 'asc')
            ->get()
            ->groupBy('kategori_pengeluaran');

        $dailyKategori0 = $dailyQuery[0] ?? collect();
        $dailyKategori1 = $dailyQuery[1] ?? collect();

        $dailyKategori0 = $dailyKategori0->keyBy('tanggal');
        $dailyKategori1 = $dailyKategori1->keyBy('tanggal');

        $dailyData = [
            'labels' => [],
            'kategori_0' => [],
            'kategori_1' => [],
        ];

        foreach ($period as $date) {
            $tanggal = $date->format('Y-m-d');
            $dailyData['labels'][] = $tanggal;
            $dailyData['kategori_0'][] = $dailyKategori0[$tanggal]->jumlah ?? 0;
            $dailyData['kategori_1'][] = $dailyKategori1[$tanggal]->jumlah ?? 0;
        }


        // 📊 Data Bulanan (12 bulan terakhir)
        $startMonth = now()->subMonths(11)->startOfMonth();
        $endMonth = now()->endOfMonth();
        
        $monthlyQuery = PengeluaranBarang::selectRaw("DATE_FORMAT(created_date, '%Y-%m') as bulan, kategori_pengeluaran, COUNT(*) as jumlah")
            ->whereBetween('created_date', [$startMonth, $endMonth])
            ->groupBy('bulan', 'kategori_pengeluaran')
            ->orderBy('bulan', 'asc')
            ->get()
            ->groupBy('kategori_pengeluaran');
        
        $monthlyKategori0 = $monthlyQuery[0] ?? collect();
        $monthlyKategori1 = $monthlyQuery[1] ?? collect();
        
        $monthlyKategori0 = $monthlyKategori0->keyBy('bulan');
        $monthlyKategori1 = $monthlyKategori1->keyBy('bulan');
        
        $monthlyData = [
            'labels' => [],
            'kategori_0' => [],
            'kategori_1' => [],
        ];
        
        for ($i = 0; $i < 12; $i++) {
            $bulan = now()->subMonths(11 - $i)->format('Y-m');
            $monthlyData['labels'][] = $bulan;
            $monthlyData['kategori_0'][] = $monthlyKategori0[$bulan]->jumlah ?? 0;
            $monthlyData['kategori_1'][] = $monthlyKategori1[$bulan]->jumlah ?? 0;
        }
        

        // 📊 Data Tahunan (5 tahun terakhir)
        $startYear = now()->subYears(4)->startOfYear();
        $endYear = now()->endOfYear();

        $yearlyQuery = PengeluaranBarang::selectRaw("YEAR(created_date) as tahun, kategori_pengeluaran, COUNT(*) as jumlah")
            ->whereBetween('created_date', [$startYear, $endYear])
            ->groupBy('tahun', 'kategori_pengeluaran')
            ->orderBy('tahun', 'asc')
            ->get()
            ->groupBy('kategori_pengeluaran');

        $yearlyKategori0 = $yearlyQuery[0] ?? collect();
        $yearlyKategori1 = $yearlyQuery[1] ?? collect();

        $yearlyKategori0 = $yearlyKategori0->keyBy('tahun');
        $yearlyKategori1 = $yearlyKategori1->keyBy('tahun');

        $yearlyData = [
            'labels' => [],
            'kategori_0' => [],
            'kategori_1' => [],
        ];

        for ($i = 0; $i < 5; $i++) {
            $tahun = now()->subYears(4 - $i)->format('Y');
            $yearlyData['labels'][] = $tahun;
            $yearlyData['kategori_0'][] = $yearlyKategori0[$tahun]->jumlah ?? 0;
            $yearlyData['kategori_1'][] = $yearlyKategori1[$tahun]->jumlah ?? 0;
        }


        // 📊 Data Pie Chart berdasarkan Departemen
        $pieQuery = PengeluaranBarang::pluck('pengeluaran_barang_id'); // Ambil hanya kolom ID
        $pieData = $pieQuery->map(function ($item) {
            $parts = explode('/', $item);
            return $parts[1] ?? null; // Ambil bagian kedua (Departemen)
        })->filter()->countBy()->toArray();

        return view('livewire.dashboard-barang-keluar', [
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
