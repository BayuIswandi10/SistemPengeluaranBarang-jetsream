<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\FormPengeluaran;
use App\Livewire\Unauthorized;
use App\Http\Controllers\PengeluaranBarangController;
use App\Livewire\FormApproval;
use App\Http\Controllers\ApprovalController;
use App\Livewire\FormSecutity;
use App\Http\Middleware\CheckLevel; 

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::middleware([CheckLevel::class . ':Level 5'])->group(function () {
        Route::get('/security', FormSecutity::class)->name('security');
    });

    Route::get('/form', FormPengeluaran::class)->name('form');
    Route::get('/approval', FormApproval::class)->name('approval');
    Route::post('/pengeluaran_barang', [PengeluaranBarangController::class, 'store'])->name('pengeluaran_barang.store');
    Route::post('/approve/{approval}', [ApprovalController::class, 'approve'])->name('approval.update');
    Route::post('/approve-security/{approval}', [ApprovalController::class, 'approveSecurity'])->name('approve.security');
    Route::get('/pengeluaran-barang/{pengeluaranBarangId}/detail', [PengeluaranBarangController::class, 'getDetail']);
    Route::post('/pengeluaran/update-status', [PengeluaranBarangController::class, 'updateStatus'])->name('pengeluaran.updateStatus');
});

Route::get('/unauthorized', Unauthorized::class)->name('unauthorized.show');
