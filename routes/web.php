<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PesananController;

// Route untuk login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Route untuk register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Route untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    // Halaman dashboard
    Route::get('/dashboard', function () {
        return view('kasir.index');
    })->name('dashboard');

    // Rute pesanan
    Route::resource('orders', PesananController::class);
    Route::post('/orders/update-status/{id}', [PesananController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/{id}', [PesananController::class, 'show']);


    // Rute paket
    Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
    Route::post('/paket', [PaketController::class, 'store'])->name('paket.store');
    Route::put('/paket/{id}', [PaketController::class, 'update'])->name('paket.update');
    Route::delete('/paket/{id}', [PaketController::class, 'destroy'])->name('paket.destroy');
});
