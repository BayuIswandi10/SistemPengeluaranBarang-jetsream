<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Approval;

class FormApproval extends Component
{
    public function render()
    {
        $approvals = Approval::with(['pengeluaranBarang.barangKeluar'])->get();
        return view('livewire.form-approval', compact('approvals'));
    }


}
