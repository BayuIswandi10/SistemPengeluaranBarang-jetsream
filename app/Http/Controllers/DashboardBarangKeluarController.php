<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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
            } elseif (in_array($user->level, ['Ka.Dept', 'Security', 'Super Admin'])) {
                $pengeluaranBarangs = $query->get();
            } else {
                $pengeluaranBarangs = collect(); // Jika level tidak dikenali, kembalikan data kosong
            }

            // Ekstrak angka dari level user
            $userLevel = (int) filter_var($user->level, FILTER_SANITIZE_NUMBER_INT);

            // Mengambil data berdasarkan status
            $pengeluaranBarangsDisetujui = $pengeluaranBarangs->filter(fn ($item) => 
                (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === $userLevel || 
                (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) > $userLevel
            )->values();

            $pengeluaranBarangsMenunggu = $pengeluaranBarangs->filter(fn ($item) =>
                (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === ($userLevel - 1)
            )->values();

            $pengeluaranBarangsDitolak = $pengeluaranBarangs->filter(fn ($item) =>
                (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === 0
            )->values();

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
