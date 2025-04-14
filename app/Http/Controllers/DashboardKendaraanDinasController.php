<?php

namespace App\Http\Controllers;

use App\Models\SuratKendaraanDinas;
use App\Models\KendaraanDinas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardKendaraanDinasController extends Controller
{
    public function index()
    {
        $suratKendaraanDinas = SuratKendaraanDinas::with('approval')->get(); 
        $kendaraanDinas = KendaraanDinas::with('user')->get();
        return view('livewire.dashboard-kendaraan-dinas', compact('suratKendaraanDinas', 'kendaraanDinas'));
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
            $query = SuratKendaraanDinas::with([
                    'user', 
                    'approval', 
                    'pencatatanKendaraanDinas', 
                    'suratDetail'
                ])
                ->whereBetween('created_date', [$startDate, $endDate]);

            // Filter data berdasarkan level user
            if ($user->level === 'Staff') {
                $suratKendaraan = $query->where(function ($q) use ($user) {
                    $q->whereHas('user', function ($query) use ($user) {
                        $query->where('departemen', $user->departemen);
                    })->orWhere('created_by', $user->nrp_karyawan);
                })->get();
            } elseif ($user->level === 'Ka.Sie') {
                $suratKendaraan = $query->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen);
                })->get();
            } elseif (in_array($user->level, ['Ka.Dept', 'Security'])) {
                $suratKendaraan = $query->get();
            } else {
                $suratKendaraan = collect(); // Jika level tidak dikenali, kembalikan data kosong
            }

            // Ekstrak angka dari level user
            $userLevel = (int) filter_var($user->level, FILTER_SANITIZE_NUMBER_INT);

            // Mengambil data berdasarkan status
            $kendaraanDisetujui = $suratKendaraan->filter(fn ($item) => 
                (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === $userLevel || 
                (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) > $userLevel
            )->values();

            $kendaraanMenunggu = $suratKendaraan->filter(fn ($item) =>
                (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === ($userLevel - 1)
            )->values();

            $kendaraanDitolak = $suratKendaraan->filter(fn ($item) =>
                (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === 0
            )->values();

            // Response JSON dengan data lengkap dan rentang tanggal
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diambil.',
                'data' => [
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'suratKendaraan' => [
                        'count' => $suratKendaraan->count(),
                        'data' => $suratKendaraan
                    ],
                    'kendaraanDisetujui' => [
                        'count' => $kendaraanDisetujui->count(),
                        'data' => $kendaraanDisetujui
                    ],
                    'kendaraanMenunggu' => [
                        'count' => $kendaraanMenunggu->count(),
                        'data' => $kendaraanMenunggu
                    ],
                    'kendaraanDitolak' => [
                        'count' => $kendaraanDitolak->count(),
                        'data' => $kendaraanDitolak
                    ],
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
