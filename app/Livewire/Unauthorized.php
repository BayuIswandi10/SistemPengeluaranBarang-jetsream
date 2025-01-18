<?php

namespace App\Livewire;

use Livewire\Component;

class Unauthorized extends Component
{
    public $log;

    public function mount($log = null)
    {
        $this->log = $log;
    }

    public function render()
    {
        return view('livewire.unauthorized');
    }
}
