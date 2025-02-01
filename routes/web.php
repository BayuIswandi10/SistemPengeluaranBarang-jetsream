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
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/pengeluaran_barang', [PengeluaranBarangController::class, 'store'])->name('pengeluaran_barang.store');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::middleware([CheckLevel::class . ':Level 5'])->group(function () {
        Route::get('/security', FormSecutity::class)->name('security');
        Route::post('/approval/update-status-security', [ApprovalController::class, 'updateStatusSecurity'])->name('approval.updateStatusSecurity');

    });

    Route::get('/form', FormPengeluaran::class)->name('form');
    Route::get('/approval', FormApproval::class)->name('approval');

    
    Route::put('/pengeluaran-barang/update', [PengeluaranBarangController::class, 'update'])->name('pengeluaran_barang.update');
    Route::post('/hapus-barang', [PengeluaranBarangController::class, 'hapusBarang'])->name('hapus.barang');
    Route::get('/pengeluaran-barang/{pengeluaranBarangId}/detail', [PengeluaranBarangController::class, 'getDetail']);
    Route::post('/pengeluaran/update-status', [PengeluaranBarangController::class, 'updateStatus'])->name('pengeluaran.updateStatus');
    Route::post('/pengeluaran/edit', [PengeluaranBarangController::class, 'edit']);
    Route::post('/pengeluaran/detail', [PengeluaranBarangController::class, 'getDetail']);
    Route::get('/pengeluaran/detail/{pengeluaran_barang_id}', [DashboardController::class, 'getDetailQty']);

    Route::post('/approve/{approval}', [ApprovalController::class, 'approve'])->name('approval.update');
    Route::post('/pengeluaran/update-status-kasie', [ApprovalController::class, 'updateStatusKaSie'])->name('approval.updateStatusKaSie');
    Route::post('/pengeluaran/update-status-kadeptybs', [ApprovalController::class, 'updateStatusKaDeptYBS'])->name('approval.updateStatusKaDeptYBS');
    Route::post('/pengeluaran/update-status-kadeptga', [ApprovalController::class, 'updateStatusKaDeptGA'])->name('approval.updateStatusKaDeptGA');
    Route::post('/pengeluaran/update-status-kasie', [ApprovalController::class, 'updateStatusKaSie'])->name('approval.updateStatusKaSie');
    // Route::post('/pengeluaran/detail', [ApprovalController::class, 'getDetail']);
    
});

Route::get('/unauthorized', Unauthorized::class)->name('unauthorized.show');
