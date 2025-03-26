<?php

namespace App\Livewire;

use App\Models\PengeluaranBarang;
use Livewire\Component;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class SecurityLiveWire extends Component
{
    public function render()
    {
        return view('livewire.form-security');
    }
}
