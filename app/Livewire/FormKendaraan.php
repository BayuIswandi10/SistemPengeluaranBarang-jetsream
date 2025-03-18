<?php

namespace App\Livewire;
use App\Models\KendaraanDinas;
use Livewire\Component;

class FormKendaraan extends Component
{
    public function render()
    {
        $kendaraanDinas = KendaraanDinas::all(); // Mengambil semua data kendaraan dinas
        return view('livewire.form-kendaraan', compact('kendaraanDinas'));
    }
}
