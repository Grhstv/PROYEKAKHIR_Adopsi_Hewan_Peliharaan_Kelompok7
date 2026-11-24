<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HewanController;
use App\Http\Controllers\Api\V1\KategoriController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('v1.')->group(function () {
    // Publik
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login');
    Route::get('kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('hewan', [HewanController::class, 'index'])->name('hewan.index');
    Route::get('hewan/{hewan}', [HewanController::class, 'show'])->name('hewan.show');

    // Wajib Bearer Token (Laravel Sanctum); izin 'kelola hewan' dicek di controller
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('hewan', [HewanController::class, 'store'])->name('hewan.store');
        Route::put('hewan/{hewan}', [HewanController::class, 'update'])->name('hewan.update');
        Route::delete('hewan/{hewan}', [HewanController::class, 'destroy'])->name('hewan.destroy');
    });
});
