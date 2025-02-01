<?php

namespace App\Http\Controllers;
use App\Models\PengeluaranBarang;

class DashboardController extends Controller
{
    public function index()
    {
        $pengeluaranBarangs = PengeluaranBarang::with('approval')->get(); 
        return view('livewire.dashboard-notif-card', compact('pengeluaranBarangs'));
    }

}
