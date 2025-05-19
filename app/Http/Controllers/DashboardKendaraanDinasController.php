<?php

namespace App\Http\Controllers;

use App\Models\SuratKendaraanDinas;
use App\Models\KendaraanDinas;
use App\Models\ApprovalKendaraanDinas;
use App\Models\SuratKendaraanDinasDetail;
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
            if ($user->level === 'Ka.Sie' && $user->seksi !== 'General Service') {
                // Ka.Sie biasa → hanya data dari departemen yang sama
                $suratKendaraan = $query->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen);
                })->get();

            } elseif (
                in_array($user->level, ['Ka.Dept', 'Security', 'Super Admin']) ||
                ($user->level === 'Ka.Sie' && $user->seksi === 'General Service')
            ) {
                // Ka.Sie dengan seksi General Service → dapat semua data
                $suratKendaraan = $query->get();

            } else {
                // Selain itu, kosong
                $suratKendaraan = collect();
            }

            $userLevel = null; 
            // Ekstrak angka dari level user
            if ($user->level === 'Ka.Dept') {
                $userLevel = 2;
            } elseif ($user->level === 'Ka.Sie' && $user->departemen === 'General Affairs') {
                $userLevel = 3;
            } elseif ($user->level === 'Security') {
                $userLevel = 4;
            }

            // Mengambil data berdasarkan status
            $approvedIdsByUser = ApprovalKendaraanDinas::where('created_by', $user->nrp_karyawan)
            ->where('status_approval', '!=', 'Level 0')
            ->pluck('surat_kendaraan_dinas_id')
            ->toArray();
            $kendaraanDisetujui = $suratKendaraan->filter(function ($item) use ($approvedIdsByUser) {
                return in_array($item->surat_kendaraan_dinas_id, $approvedIdsByUser);
            })->values();

            $kendaraanMenunggu = $suratKendaraan->filter(fn ($item) =>
                (int) filter_var($item->status, FILTER_SANITIZE_NUMBER_INT) === ($userLevel - 1)
            )->values();

            $rejectedIdsByUser = ApprovalKendaraanDinas::where('created_by', $user->nrp_karyawan)
            ->where('status_approval', 'Level 0')
            ->pluck('surat_kendaraan_dinas_id')
            ->toArray();
            $kendaraanDitolak = $suratKendaraan->filter(function ($item) use ($rejectedIdsByUser) {
                return in_array($item->surat_kendaraan_dinas_id, $rejectedIdsByUser);
            })->values();
    
            // 1. Ambil semua surat kendaraan dinas dalam rentang tanggal
            $suratIds = SuratKendaraanDinas::whereBetween('created_date', [$startDate, $endDate])
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
                ->values();

            // Kendaraan yang tersedia dan jenis_kendaraan == 1
            $kendaraanDinasTersedia = $filteredKendaraanDinas
                ->whereNotIn('kendaraan_dinas_id', $kendaraanDigunakanIds)
                ->values();

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
                    'suratKendaraanDisetujui' => [
                        'count' => $kendaraanDisetujui->count(),
                        'data' => $kendaraanDisetujui
                    ],
                    'suratKendaraanMenunggu' => [
                        'count' => $kendaraanMenunggu->count(),
                        'data' => $kendaraanMenunggu
                    ],
                    'suratKendaraanDitolak' => [
                        'count' => $kendaraanDitolak->count(),
                        'data' => $kendaraanDitolak
                    ],
                    'kendaraanDinasSedangDigunakan' => [
                        'count' => $kendaraanDinasSedangDigunakan->count(),
                        'data' => $kendaraanDinasSedangDigunakan
                    ],
                    'kendaraanDinasTersedia' => [
                        'count' => $kendaraanDinasTersedia->count(),
                        'data' => $kendaraanDinasTersedia
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
