<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\PengeluaranBarang;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class ApprovalBarangKeluarLiveWire extends Component
{
    public $startDate;
    public $endDate;
    public $pengeluaranBarangs;

    public function mount()
    {
        $this->startDate = Carbon::now()->subMonthNoOverflow()->startOfMonth()->format('Y-m-d 00:00:00');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->pengeluaranBarangs = $this->fetchPengeluaranBarangs();
    }

   protected $listeners = ['updateDateRange' => 'updateDateRange'];

    public function updateDateRange($data = null)
    {
        if ($data) {
            $this->startDate = $data['startDate'];
            $this->endDate = $data['endDate'];
        }
       
        $this->pengeluaranBarangs = $this->fetchPengeluaranBarangs();
        $this->dispatch('dataUpdated');
    }


    private function fetchPengeluaranBarangs()
    {
        $user = Auth::user();
        $query = PengeluaranBarang::with(['user', 'approval', 'barangKeluar']);

        $start = Carbon::parse($this->startDate)->setTimezone('Asia/Jakarta')->startOfDay();
        $end = Carbon::parse($this->endDate)->setTimezone('Asia/Jakarta')->endOfDay();

        if ($user->departemen === 'Finance') {
            return (clone $query)
                ->whereBetween('created_date', [$start, $end])
                ->where('kategori_pengeluaran', 1)
                ->orderByRaw("FIELD(status, 'Level 4') DESC")
                ->orderBy('status', 'asc')
                ->get();
        } elseif ($user->level === 'Staff') {
            return (clone $query)->where(function ($q) use ($user) {
                $q->whereHas('user', function ($query) use ($user) {
                    $query->where('departemen', $user->departemen);
                })->orWhere('created_by', $user->nrp_karyawan);
            })
            ->whereBetween('created_date', [$start, $end])
            ->get();
        } elseif ($user->level === 'Ka.Sie') {
            return (clone $query)->whereHas('user', function ($query) use ($user) {
                $query->where('departemen', $user->departemen);
            })
            ->whereBetween('created_date', [$start, $end])
            ->orderByRaw("FIELD(status, 'Level 1') DESC")
            ->orderBy('status', 'asc')
            ->get();
        } elseif ($user->level === 'Ka.Dept' && $user->departemen !== 'General Affairs') {
            return (clone $query)->whereHas('user', function ($query) use ($user) {
                $query->where('departemen', $user->departemen);
            })
            ->whereBetween('created_date', [$start, $end])
            ->orderByRaw("FIELD(status, 'Level 2') DESC")
            ->orderBy('status', 'asc')
            ->get();
        } elseif ($user->level === 'Ka.Dept' && $user->departemen === 'General Affairs') {
            $level2FromGA = (clone $query)
                ->whereBetween('created_date', [$start, $end])
                ->where('status', 'Level 2')
                ->whereHas('user', function ($q) {
                    $q->where('departemen', 'General Affairs');
                })
                ->get();

            $others = (clone $query)
                ->whereBetween('created_date', [$start, $end])
                ->where(function ($q) {
                    $q->where('status', '!=', 'Level 2')
                    ->orWhereHas('user', function ($q2) {
                        $q2->where('departemen', '!=', 'General Affairs');
                    });
                })
                ->orderByRaw("FIELD(status, 'Level 3') DESC")
                ->orderBy('status', 'asc')
                ->get();

            return $level2FromGA->concat($others);
        } elseif ($user->level === 'Super Admin') {
            return (clone $query)
                ->whereBetween('created_date', [$start, $end])
                ->where('status', '!=', 'Level 0')
                ->orderBy('created_date', 'desc')
                ->get();
        } else {
            return collect();
        }
    }


   public function render()
    {
        $user = Auth::user();
        return view('livewire.form-approval', [
            'pengeluaranBarangs' => $this->pengeluaranBarangs,
            'user' => $user,
        ]);
    }

}
