<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\ProductApiController; 
use App\Http\Controllers\DashboardController; // <<< DIPERLUKAN UNTUK ROUTE BARU
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// >>> GANTI: ROUTE DASHBOARD LAMA DENGAN CONTROLLER BARU <<<
Route::get('/dashboard', [DashboardController::class, 'index']) // <<< INI PERUBAHAN UTAMANYA
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
// -------------------------------------------------------------

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Resource Route Produk (Web): Wajib Login
    Route::resource('products', ProductController::class);
});

// --- API ROUTE CADANGAN (DIPINDAH DARI API.PHP) ---
// Kita tambahkan prefix 'api' secara manual di sini.
Route::prefix('api')->group(function () {
    // Akses: GET /api/products-stok
    Route::get('/products-stok', [ProductApiController::class, 'index']);
});
// -----------------------------------------------------

require __DIR__.'/auth.php';