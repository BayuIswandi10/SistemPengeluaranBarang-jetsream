<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    public function scanner()
    {
        return view('landing.form-scan-qr-code');
    }
}
