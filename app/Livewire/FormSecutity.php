<?php

namespace App\Livewire;
use App\Models\Approval;
use Livewire\Component;

class FormSecutity extends Component
{
    public function render()
    {
        $approvals = Approval::with(['pengeluaranBarang.barangKeluar'])->get();
        return view('livewire.form-secutity', compact('approvals'));
    }
}
