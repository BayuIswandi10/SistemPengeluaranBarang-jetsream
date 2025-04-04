<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Unauthorized;
use App\Livewire\DashboardBarangKeluarLiveWire;
use App\Livewire\PengeluaranBarangLiveWire;
use App\Livewire\ApprovalBarangKeluarLiveWire;
use App\Livewire\SecurityLiveWire;
use App\Livewire\KendaraanDinasLiveWire;
use App\Livewire\ApprovalKendaraanDinasLivewire;

use App\Http\Controllers\PengeluaranBarangController;
use App\Http\Controllers\ApprovalBarangKeluarController;
use App\Http\Controllers\DashboardBarangKeluarController;
use App\Http\Controllers\KendaraanDinasController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\SuratDinasController;
use App\Http\Controllers\ApprovalKendaraanDinasController;

use App\Http\Middleware\CheckLevel; 
    
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', DashboardBarangKeluarLiveWire::class)->name('dashboard');

    Route::middleware([CheckLevel::class . ':Security'])->group(function () {
        Route::get('/security', SecurityLiveWire::class)->name('security');
        Route::post('/approval/update-status-security', [ApprovalBarangKeluarController::class, 'updateStatusSecurity'])->name('approval.updateStatusSecurity');
    });

    Route::middleware([CheckLevel::class . ':Super Admin'])->group(function () {
        Route::get('/form', PengeluaranBarangLiveWire::class)->name('form');
        Route::get('/kendaraan', KendaraanDinasLiveWire::class)->name('kendaraan');
    });

    Route::get('/approval', ApprovalBarangKeluarLiveWire::class)->name('approval');
    Route::get('/approval-dinas', ApprovalKendaraanDinasLivewire::class)->name('approval-dinas');


    Route::get('/dashboard/get-data-card', [DashboardBarangKeluarController::class, 'getData']);
    
    Route::put('/pengeluaran-barang/update', [PengeluaranBarangController::class, 'update'])->name('pengeluaran_barang.update');
    Route::post('/hapus-barang', [PengeluaranBarangController::class, 'hapusBarang'])->name('hapus.barang');
    Route::post('/generate-qrcode', [PengeluaranBarangController::class, 'generateQRCode']);
    Route::post('/pengeluaran/detail', [PengeluaranBarangController::class, 'getDetail']);
    
    Route::post('/approve/{approval}', [ApprovalBarangKeluarController::class, 'approve'])->name('approval.update');
    Route::post('/pengeluaran/update-status-kasie', [ApprovalBarangKeluarController::class, 'updateStatusKaSie'])->name('approval.updateStatusKaSie');
    Route::post('/pengeluaran/update-status-kadeptybs', [ApprovalBarangKeluarController::class, 'updateStatusKaDeptYBS'])->name('approval.updateStatusKaDeptYBS');
    Route::post('/pengeluaran/update-status-kadeptga', [ApprovalBarangKeluarController::class, 'updateStatusKaDeptGA'])->name('approval.updateStatusKaDeptGA');
    Route::post('/pengeluaran/update-status-kasie', [ApprovalBarangKeluarController::class, 'updateStatusKaSie'])->name('approval.updateStatusKaSie');
    Route::post('/pengeluaran/update-status-finance', [ApprovalBarangKeluarController::class, 'updateStatusFinance'])->name('approval.updateStatusFinance');
    Route::post('/pengeluaran/reject-status', [ApprovalBarangKeluarController::class, 'rejectStatus'])->name('approval.rejectStatus');

    Route::post('/kendaraan', [KendaraanDinasController::class, 'store'])->name('kendaraan.store');    
    Route::get('/kendaraan/edit', [KendaraanDinasController::class, 'edit'])->name('kendaraan.edit');
    Route::put('/kendaraan/update', [KendaraanDinasController::class, 'update'])->name('kendaraan.update');
    Route::post('/kendaraan/nonAktif', [KendaraanDinasController::class, 'nonAktif'])->name('kendaraan.nonAktif');    

    Route::post('/pengajuan/detailSurat', [SuratDinasController::class, 'getDetailSurat']);
    Route::post('/pengajuan/edit', [SuratDinasController::class, 'edit'])->name('pengajuan.edit');

    Route::post('/pengajuanDinas/update-status-kadeptybs', [ApprovalKendaraanDinasController::class, 'updateStatusKaDeptYBS'])->name('pengajuanDinas.updateStatusKaDeptYBS');
    Route::post('/pengajuanDinas/update-status-kasietransportasi', [ApprovalKendaraanDinasController::class, 'updateStatusKaSieTransport'])->name('pengajuanDinas.updateStatusKaSieTransport');
    Route::post('/pengajuanDinas/reject-status', [ApprovalKendaraanDinasController::class, 'rejectStatus'])->name('pengajuanDinas.rejectStatus');

});
Route::post('/pengeluaran_barang', [PengeluaranBarangController::class, 'store'])->name('pengeluaran_barang.store');
Route::post('/pengeluaran/edit', [PengeluaranBarangController::class, 'edit'])->name('pengeluaran.edit');
Route::post('/pengeluaran/detailNonAuth', [PengeluaranBarangController::class, 'getDetailNonAuth']);
Route::get('/pengeluaran/get-data-level4', [PengeluaranBarangController::class, 'getDataLevel4']);

Route::post('/approval/update-nopolisi', [ApprovalBarangKeluarController::class, 'updateNopolisi'])->name('approval.updateNopolisi');

Route::get('/kamera', [QRCodeController::class, 'scanner'])->name('kamera');

Route::get('/unauthorized', Unauthorized::class)->name('unauthorized.show');

Route::post('/pengajuan_dinas', [SuratDinasController::class, 'store'])->name('pengajuan_dinas.store');
Route::get('/getUserDetails', [SuratDinasController::class, 'getUserDetails'])->name('pengajuan_dinas.getUserDetails');