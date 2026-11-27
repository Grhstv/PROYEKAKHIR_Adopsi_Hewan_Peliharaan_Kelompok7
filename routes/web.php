<?php

use App\Http\Controllers\Admin\AdopsiController as AdminAdopsiController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Controllers\Admin\HewanController as AdminHewanController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\SellerApplicationController as AdminSellerApplicationController;
use App\Http\Controllers\Admin\SyaratKetentuanController as AdminSyaratKetentuanController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AdopsiController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\ShopController as SellerShopController;
use App\Http\Controllers\SellerApplicationController;
use App\Http\Controllers\SyaratKetentuanController;
use Illuminate\Support\Facades\Route;

/* ---------- Publik ---------- */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/hewan', [HewanController::class, 'index'])->name('hewan.index');
Route::get('/hewan/{hewan}', [HewanController::class, 'show'])->name('hewan.show');
Route::get('/syarat-ketentuan', [SyaratKetentuanController::class, 'show'])->name('syarat-ketentuan.show');
Route::view('/katalog-live', 'klien.katalog')->name('katalog.live'); // klien Fetch API
Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('/marketplace/{product}', [MarketplaceController::class, 'show'])->name('marketplace.show');
Route::get('/toko/{shop:slug}', [MarketplaceController::class, 'shop'])->name('shops.show');

/* ---------- Wajib login ---------- */
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin', [DashboardController::class, 'admin'])
        ->middleware('can:akses area admin')->name('admin.dashboard');
    Route::get('/petugas', [DashboardController::class, 'petugas'])
        ->middleware('can:akses area petugas')->name('petugas.dashboard');

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
    });

    Route::middleware('can:lihat chat')->group(function () {
        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
        Route::post('/chat', [ChatController::class, 'store'])->middleware('throttle:20,1')->name('chat.store');
    });

    Route::middleware('can:belanja produk')->group(function () {
        Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
        Route::post('/keranjang/{product}', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/keranjang/{cartItem}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/keranjang/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::post('/checkout', [CartController::class, 'checkout'])->middleware('throttle:10,1')->name('cart.checkout');
        Route::get('/pesanan-saya', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/pesanan-saya/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/pesanan-saya/{order}/batal', [OrderController::class, 'cancel'])->name('orders.cancel');
    });

    Route::middleware('can:mengajukan menjadi seller')->group(function () {
        Route::get('/pengajuan-seller', [SellerApplicationController::class, 'create'])->name('seller.application.create');
        Route::post('/pengajuan-seller', [SellerApplicationController::class, 'store'])->name('seller.application.store');
    });

    Route::prefix('seller')->name('seller.')->middleware('can:kelola toko')->group(function () {
        Route::get('/', [SellerShopController::class, 'index'])->name('dashboard');
        Route::resource('products', SellerProductController::class)->except(['show']);
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{order}', [SellerOrderController::class, 'update'])->name('orders.update');
    });

    Route::prefix('admin')->name('admin.')->middleware('can:akses area admin')->group(function () {
        Route::middleware('can:kelola chat')->group(function () {
            Route::get('chat', [AdminChatController::class, 'index'])->name('chat.index');
            Route::post('chat/broadcast', [AdminChatController::class, 'broadcast'])->name('chat.broadcast');
            Route::get('chat/{conversation}', [AdminChatController::class, 'show'])->name('chat.show');
            Route::post('chat/{conversation}', [AdminChatController::class, 'store'])->name('chat.store');
        });

        Route::middleware('can:kelola pengajuan seller')->group(function () {
            Route::get('pengajuan-seller', [AdminSellerApplicationController::class, 'index'])->name('seller-applications.index');
            Route::post('pengajuan-seller/{sellerApplication}/setujui', [AdminSellerApplicationController::class, 'approve'])->name('seller-applications.approve');
            Route::post('pengajuan-seller/{sellerApplication}/tolak', [AdminSellerApplicationController::class, 'reject'])->name('seller-applications.reject');
        });

        Route::get('laporan', [ReportController::class, 'admin'])
            ->middleware('can:lihat laporan')->name('laporan.index');

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
        });

        Route::middleware('can:kelola pengguna')->group(function () {
            Route::get('pengguna', [AdminUserController::class, 'index'])->name('pengguna.index');
            Route::patch('pengguna/{user}/role', [AdminUserController::class, 'updateRole'])->name('pengguna.role');
        });
    });

    Route::prefix('petugas')->name('petugas.')->middleware('can:akses area petugas')->group(function () {
        Route::middleware('can:kelola hewan')->group(function () {
            Route::resource('hewan', AdminHewanController::class)->except('show')->parameters(['hewan' => 'hewan']);
        });

        Route::middleware('can:kelola pengajuan adopsi')->group(function () {
            Route::get('adopsi', [AdminAdopsiController::class, 'index'])->name('adopsi.index');
            Route::post('adopsi/{adopsi}/setujui', [AdminAdopsiController::class, 'setujui'])->name('adopsi.setujui');
            Route::post('adopsi/{adopsi}/tolak', [AdminAdopsiController::class, 'tolak'])->name('adopsi.tolak');
        });
    });
});

require __DIR__.'/auth.php';
