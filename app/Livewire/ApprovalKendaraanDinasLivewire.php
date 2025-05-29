<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\SuratKendaraanDinas;
use Illuminate\Support\Facades\Auth;

class ApprovalKendaraanDinasLivewire extends Component
{
    public $startDate;
    public $endDate;
    public $kendaraanDinas;

    protected $listeners = ['updateDateRange' => 'updateDateRange'];

    public function mount()
    {
        $this->startDate = Carbon::now()->subMonthNoOverflow()->startOfMonth()->format('Y-m-d 00:00:00');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d 23:59:59');
        $this->kendaraanDinas = $this->fetchKendaraanDinas();
    }

    public function updateDateRange($data = null)
    {
        if ($data) {
            $this->startDate = $data['startDate'];
            $this->endDate = $data['endDate'];
        }

        $this->kendaraanDinas = $this->fetchKendaraanDinas();
        $this->dispatch('dataUpdated');
    }

    private function fetchKendaraanDinas()
    {
        $user = Auth::user();
        $query = SuratKendaraanDinas::with(['user', 'approval', 'pencatatanKendaraanDinas']);

        $start = Carbon::parse($this->startDate)->setTimezone('Asia/Jakarta')->startOfDay();
        $end = Carbon::parse($this->endDate)->setTimezone('Asia/Jakarta')->endOfDay();

        if (in_array($user->level, ['Ka.Sie']) && $user->seksi !== 'General Service') {
            return (clone $query)->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen);
                })
                ->whereBetween('created_date', [$start, $end])
                ->get();
        } elseif ($user->level === 'Ka.Dept' && $user->departemen !== 'General Affairs') {
            return (clone $query)->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen);
                })
                ->whereBetween('created_date', [$start, $end])
                ->orderByRaw("FIELD(status, 'Level 1') DESC")
                ->orderBy('status', 'asc')
                ->get();
        } elseif (
            in_array($user->level, ['Ka.Dept', 'Security', 'Super Admin']) ||
            ($user->level === 'Ka.Sie' && $user->seksi === 'General Service')
        ) {
            return (clone $query)
                ->whereBetween('created_date', [$start, $end])
                ->orderByRaw("FIELD(status, 'Level 2') DESC")
                ->get();
        } else {
            return collect();
        }
    }

    public function render()
    {
        $user = Auth::user();
        return view('livewire.approval-kendaraan-dinas-livewire', [
            'kendaraanDinas' => $this->kendaraanDinas,
            'user' => $user,
        ]);
    }
}
