<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\AuthController;

// Public routes
Route::get('/', [PesertaController::class, 'create'])->name('home');
Route::post('/daftar', [PesertaController::class, 'store'])->name('pendaftaran.store');

// Admin authentication routes
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Protected admin routes
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [PesertaController::class, 'dashboard'])->name('admin.dashboard');
    Route::delete('/peserta/{id}', [PesertaController::class, 'destroy'])->name('peserta.destroy');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('admin.register');
    Route::post('/register', [AuthController::class, 'register'])->name('admin.register.submit');
});
