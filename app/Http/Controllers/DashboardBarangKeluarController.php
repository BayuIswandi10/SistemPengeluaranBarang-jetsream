<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ApprovalBarangKeluar;
use App\Models\PengeluaranBarang;

use Illuminate\Support\Facades\Auth;

class DashboardBarangKeluarController extends Controller
{
    public function index()
    {
        $pengeluaranBarangs = PengeluaranBarang::with('approval')->get(); 
        return view('livewire.dashboard-barang-keluar', compact('pengeluaranBarangs'));
    }

    public function getData(Request $request)
    {
        try {
            $user = Auth::user();
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');
            $isSecurityOrSuperAdmin = false;

            if (!$startDate || !$endDate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter tanggal tidak lengkap.'
                ], 400);
            }

            // Query awal dengan relasi dan rentang tanggal
            $query = PengeluaranBarang::with(['user', 'approval', 'barangKeluar'])
                ->whereBetween('created_date', [$startDate, $endDate]);

            // Filter data berdasarkan level user
            if ($user->departemen === 'FINANCE')  {
                $pengeluaranBarangs = $query->where('kategori_pengeluaran', 1)->get();
            } elseif ($user->level === 'Ka.Dept' && $user->departemen === 'GENERAL AFFAIRS') {
                $pengeluaranBarangs = $query->get();
            }elseif (in_array($user->level,['Ka.Sie','Ka.Dept'])) {
                $pengeluaranBarangs = $query->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen);
                })->get();
            } elseif (in_array($user->level, ['Security', 'Super Admin'])) {
                $pengeluaranBarangs = $query->get();
            } 
            else {
                $pengeluaranBarangs = collect(); // Jika level tidak dikenali, kembalikan data kosong
            }

            // Ekstrak angka dari level user
            if ($user->departemen === 'FINANCE') {
                $userLevel = 5;
            } elseif ($user->level === 'Ka.Sie') {
                $userLevel = 2;
            } elseif ($user->level === 'Ka.Dept' && $user->departemen === 'GENERAL AFFAIRS') {
                $userLevel = 4;
            } elseif ($user->level === 'Ka.Dept') {
                $userLevel = 3;
            } elseif ($user->level === 'Security') {
                $userLevel = 6;
                $isSecurityOrSuperAdmin = true;
            } elseif ($user->level === 'Super Admin') {
                $userLevel = 6;
                $isSecurityOrSuperAdmin = true;
            } else {
                $userLevel = 1; // default fallback jika tidak dikenali
                 $isSecurityOrSuperAdmin = false;
            }

            //Mengambil NRP yang login dan untuk mengambil persetujuan
            if ($isSecurityOrSuperAdmin) {
                $approvedIdsByUser = ApprovalBarangKeluar::where('created_by', $user->nrp_karyawan)
                    ->whereIn('status_approval', ['Level 5', 'Level 6'])
                    ->pluck('pengeluaran_barang_id')
                    ->toArray();
            } else {
                $approvedIdsByUser = ApprovalBarangKeluar::where('created_by', $user->nrp_karyawan)
                    ->where('status_approval', '=', 'Level ' . $userLevel)
                    ->pluck('pengeluaran_barang_id')
                    ->toArray();
            }

            $pengeluaranBarangsDisetujui = $pengeluaranBarangs->filter(function ($item) use ($approvedIdsByUser) {
                return in_array($item->pengeluaran_barang_id, $approvedIdsByUser);
            })->values();

            $pengeluaranBarangsMenunggu = $pengeluaranBarangs->filter(function ($item) use ($userLevel, $isSecurityOrSuperAdmin) {
                $itemLevel = (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT);

                if ($isSecurityOrSuperAdmin ?? false) {
                    return in_array($itemLevel, [4, 5]); // lihat level 4 dan 5
                }

                return $itemLevel === ($userLevel - 1);
            })->values();

           if ($isSecurityOrSuperAdmin) {
                // Ambil SEMUA data yang ditolak
                $rejectedIdsByUser = ApprovalBarangKeluar::where('status_approval', 'Level 0')
                    ->pluck('pengeluaran_barang_id')
                    ->toArray();
            } else {
                // Ambil yang ditolak oleh user yang login (jika memang perlu dibatasi begitu)
                $rejectedIdsByUser = ApprovalBarangKeluar::where('created_by', $user->nrp_karyawan)
                    ->where('status_approval', 'Level 0')
                    ->pluck('pengeluaran_barang_id')
                    ->toArray();
            }
            $pengeluaranBarangsDitolak = $pengeluaranBarangs->filter(function ($item) use ($rejectedIdsByUser) {
                return in_array($item->pengeluaran_barang_id, $rejectedIdsByUser);
            })->values();
            

            // Response JSON dengan data lengkap dan rentang tanggal
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diambil.',
                'data' => [
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'pengeluaranBarangs' => [
                        'count' => $pengeluaranBarangs->count(),
                        'data' => $pengeluaranBarangs
                    ],
                    'pengeluaranBarangsDisetujui' => [
                        'count' => $pengeluaranBarangsDisetujui->count(),
                        'data' => $pengeluaranBarangsDisetujui
                    ],
                    'pengeluaranBarangsMenunggu' => [
                        'count' => $pengeluaranBarangsMenunggu->count(),
                        'data' => $pengeluaranBarangsMenunggu
                    ],
                    'pengeluaranBarangsDitolak' => [
                        'count' => $pengeluaranBarangsDitolak->count(),
                        'data' => $pengeluaranBarangsDitolak
                    ],
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage() // Pesan error lengkap untuk debug
            ], 500);
        }
    }
}
