<?php

use App\Http\Controllers\Admin\AdopsiController as AdminAdopsiController;
use App\Http\Controllers\Admin\HewanController as AdminHewanController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\SupportChatController as AdminSupportChatController;
use App\Http\Controllers\Admin\SyaratKetentuanController as AdminSyaratKetentuanController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AdopsiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupportChatController;
use App\Http\Controllers\SyaratKetentuanController;
use Illuminate\Support\Facades\Route;

/* ---------- Publik ---------- */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/hewan', [HewanController::class, 'index'])->name('hewan.index');
Route::get('/hewan/{hewan}', [HewanController::class, 'show'])->name('hewan.show');
Route::get('/syarat-ketentuan', [SyaratKetentuanController::class, 'show'])->name('syarat-ketentuan.show');
Route::view('/katalog-live', 'klien.katalog')->name('katalog.live'); // klien Fetch API

/* ---------- Wajib login ---------- */
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Adopter
    Route::middleware('can:mengajukan adopsi')->group(function () {
        Route::get('/hewan/{hewan}/adopsi', [AdopsiController::class, 'create'])->name('adopsi.create');
        Route::post('/hewan/{hewan}/adopsi', [AdopsiController::class, 'store'])
            ->middleware('throttle:10,1')->name('adopsi.store');
    });
    Route::middleware('can:melihat riwayat adopsi sendiri')->group(function () {
        Route::get('/adopsi-saya', [AdopsiController::class, 'index'])->name('adopsi.index');
        Route::delete('/adopsi-saya/{adopsi}', [AdopsiController::class, 'destroy'])->name('adopsi.destroy');
        Route::get('/chat-admin', [SupportChatController::class, 'show'])->name('chat.index');
        Route::post('/chat-admin', [SupportChatController::class, 'store'])
            ->middleware('throttle:10,1')->name('chat.store');
    });

    // Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware('can:kelola hewan')->group(function () {
            Route::resource('hewan', AdminHewanController::class)->except('show')->parameters(['hewan' => 'hewan']);
        });

        Route::middleware('can:kelola kategori')->group(function () {
            Route::resource('kategori', AdminKategoriController::class)
                ->except(['create', 'show'])->parameters(['kategori' => 'kategori']);
        });

        Route::middleware('can:kelola syarat dan ketentuan')->group(function () {
            Route::get('syarat-ketentuan', [AdminSyaratKetentuanController::class, 'edit'])
                ->name('syarat-ketentuan.edit');
            Route::put('syarat-ketentuan', [AdminSyaratKetentuanController::class, 'update'])
                ->name('syarat-ketentuan.update');
        });

        Route::middleware('can:kelola pengajuan adopsi')->group(function () {
            Route::get('adopsi', [AdminAdopsiController::class, 'index'])->name('adopsi.index');
            Route::post('adopsi/{adopsi}/setujui', [AdminAdopsiController::class, 'setujui'])->name('adopsi.setujui');
            Route::post('adopsi/{adopsi}/tolak', [AdminAdopsiController::class, 'tolak'])->name('adopsi.tolak');
            Route::get('laporan', [ReportController::class, 'admin'])->name('laporan.index');
        });

        Route::middleware('can:kelola pesan pelanggan')->group(function () {
            Route::get('pesan', [AdminSupportChatController::class, 'index'])->name('chat.index');
            Route::get('pesan/{conversation}', [AdminSupportChatController::class, 'show'])->name('chat.show');
            Route::post('pesan/{conversation}', [AdminSupportChatController::class, 'store'])
                ->middleware('throttle:30,1')->name('chat.store');
        });

        Route::middleware('can:kelola pengguna')->group(function () {
            Route::get('pengguna', [AdminUserController::class, 'index'])->name('pengguna.index');
            Route::patch('pengguna/{user}/role', [AdminUserController::class, 'updateRole'])->name('pengguna.role');
        });
    });
});

require __DIR__.'/auth.php';
