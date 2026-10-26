<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SanitasiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('sanitasi')->group(function () {
    // 1. Sektor Security Logins
    Route::post('/login', [SanitasiController::class, 'login']);
    Route::post('/logout', [SanitasiController::class, 'logout']);
    // 1.5. Dynamic Data
    Route::get('/list-jalan', [SanitasiController::class, 'getListJalan']);

    // 2. Modul Rumah Tangga (Data Pendataan)
    Route::post('/store-rt', [SanitasiController::class, 'storeRumahTangga']);
    Route::get('/riwayat-rt', [SanitasiController::class, 'getRiwayatRT']);

    // 3. Modul Sanitasi Komunal
    Route::post('/simpan-komunal', [SanitasiController::class, 'storeKomunal']);
    Route::get('/list-komunal', [SanitasiController::class, 'getListKomunal']);
    Route::get('/riwayat-komunal', [SanitasiController::class, 'getRiwayatKomunal']);

    // 4. Modul Jaringan SPAL
    Route::post('/store-spal', [SanitasiController::class, 'storeSpal']);
    Route::get('/riwayat-spal', [SanitasiController::class, 'getRiwayatSpal']);

    // 5. Modul Pelaporan Aduan & Riwayat Gabungan
    Route::post('/simpan-laporan', [SanitasiController::class, 'storeLaporan']);
    Route::get('/riwayat-pelaporan', [SanitasiController::class, 'getRiwayatPelaporan']);
    
    // 6. Sektor Hapus Data (Global)
    Route::post('/delete-data', [SanitasiController::class, 'deleteData']);
});