<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\FormPengeluaran;
use App\Http\Controllers\PengeluaranBarangController;
use App\Livewire\FormApproval;
use App\Http\Controllers\ApprovalController;
use App\Livewire\FormSecutity;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard',Dashboard::class)->name('dashboard');
    Route::get('/form',FormPengeluaran::class)->name('form');
    Route::get('/approval',FormApproval::class)->name('approval');
    Route::get('/security',FormSecutity::class)->name('security');

    Route::post('/pengeluaran_barang', [PengeluaranBarangController::class, 'store'])->name('pengeluaran_barang.store');
    Route::post('/approve/{approval}', [ApprovalController::class, 'approve'])->name('approval.update');
});
