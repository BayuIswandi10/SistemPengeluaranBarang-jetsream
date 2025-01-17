<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PengeluaranBarang;

class FormApproval extends Component
{

    public function render()
    {
        $pengeluaranBarangs = PengeluaranBarang::with(['approval', 'barangKeluar'])->get(); 
        return view('livewire.form-approval', compact('pengeluaranBarangs'));
        
    }


}
