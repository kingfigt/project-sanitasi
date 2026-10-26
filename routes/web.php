<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataSanitasiController;
use App\Http\Controllers\JalanController;

use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// =======================================================================
// AUTENTIKASI ADMIN (LOGIN & LOGOUT WEB)
// =======================================================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =======================================================================
// DASHBOARD & DATA UTAMA MANAGEMENT WEB ADMIN
// =======================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/data-sanitasi', [DataSanitasiController::class, 'index'])->name('admin.data_sanitasi');
    
    // Aksi Update Dropdown Status Perbaikan Masalah Sanitasi dari Petugas
    Route::post('/admin/data-sanitasi/update-status', [DataSanitasiController::class, 'updateStatusPerbaikan'])->name('admin.update_status_perbaikan');
    
    // Ekspor Laporan
    Route::get('/admin/data-sanitasi/export/{type}/{format}', [DataSanitasiController::class, 'exportData'])->name('admin.export_data');
    
    // =======================================================================
    // MANAGEMENT USER (HALAMAN & PROSES SIMPAN REAL DATABASE PETUGAS BARU)
    // =======================================================================
    // 1. Rute GET untuk merender file view halaman tambah_user.blade.php
    Route::get('/tambah-user', [DashboardController::class, 'tambahUser'])->name('users.create');
    
    // 2. Rute POST untuk memproses form submit pendaftaran user baru ke database MySQL Laragon
    Route::post('/tambah-user/store', [DashboardController::class, 'storeUser'])->name('admin.users.store');
    
    // 3. Rute POST untuk update user
    Route::post('/tambah-user/update/{id}', [DashboardController::class, 'updateUser'])->name('admin.users.update');
    
    // 4. Rute POST (atau GET dengan form hack) untuk hapus user
    Route::post('/tambah-user/delete/{id}', [DashboardController::class, 'deleteUser'])->name('admin.users.delete');
    
    // =======================================================================
    // MANAGEMENT JALAN
    // =======================================================================
    Route::get('/jalan', [JalanController::class, 'index'])->name('jalan.index');
    Route::post('/jalan', [JalanController::class, 'store'])->name('jalan.store');
    Route::delete('/jalan/{id}', [JalanController::class, 'destroy'])->name('jalan.destroy');
});