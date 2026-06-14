<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NasabahController;
use App\Http\Controllers\Admin\WasteCategoryController;
use App\Http\Controllers\Admin\WastePriceController as AdminWastePriceController;
use App\Http\Controllers\Admin\PickupController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SelfDeliveryController as AdminSelfDeliveryController;

use App\Http\Controllers\Nasabah\DashboardController as NasabahDashboardController;
use App\Http\Controllers\Nasabah\PickupRequestController;
use App\Http\Controllers\Nasabah\SelfDeliveryController;
use App\Http\Controllers\Nasabah\TransactionHistoryController;
use App\Http\Controllers\Nasabah\WalletController;
use App\Http\Controllers\Nasabah\WastePriceController as NasabahWastePriceController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();
        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('nasabah.dashboard');
    })->name('dashboard');

    // Profile (default dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== NASABAH =====
    Route::middleware('verified')->prefix('nasabah')->name('nasabah.')->group(function () {
        Route::get('/dashboard', [NasabahDashboardController::class, 'index'])->name('dashboard');

        Route::get('/harga-sampah', [NasabahWastePriceController::class, 'index'])->name('harga-sampah');

        Route::resource('pickup', PickupRequestController::class);
        Route::resource('antar-sendiri', SelfDeliveryController::class);

        Route::get('/riwayat', [TransactionHistoryController::class, 'index'])->name('riwayat');

        Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
        Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');
    });

    // ===== ADMIN =====
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('nasabah', NasabahController::class);
        Route::resource('jenis-sampah', WasteCategoryController::class);
        Route::resource('harga-sampah', AdminWastePriceController::class);
        Route::resource('pickup', PickupController::class);
        Route::resource('transaksi', TransactionController::class);

        Route::get('/antar-sendiri', [AdminSelfDeliveryController::class, 'index'])->name('antar-sendiri.index');
        Route::get('/antar-sendiri/{antar_sendiri}', [AdminSelfDeliveryController::class, 'show'])->name('antar-sendiri.show');
        Route::put('/antar-sendiri/{antar_sendiri}', [AdminSelfDeliveryController::class, 'update'])->name('antar-sendiri.update');

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/pdf', [ReportController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('/laporan/excel', [ReportController::class, 'exportExcel'])->name('laporan.excel');
    });
});

require __DIR__.'/auth.php';