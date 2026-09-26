<?php

use App\Http\Controllers\Api\V1\CalculatorController;
use App\Http\Controllers\Api\V1\PackageController;
use App\Http\Controllers\Api\V1\SiteInfoController;
use App\Http\Controllers\Api\V1\WeatherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (TiketDieng Mobile & Public Gateway)
|--------------------------------------------------------------------------
|
| Rute publik berikut dikhususkan untuk aplikasi mobile dan pengunjung umum.
| Tidak memerlukan Bearer Token (Guest Friendly).
|
*/

Route::prefix('v1')->group(function () {
    // Debugging route untuk memeriksa render HomeController@index
    Route::get('/debug-home', function () {
        try {
            $req = request();
            $ctrl = new \App\Http\Controllers\HomeController();
            $resp = $ctrl->index($req);
            return response()->json([
                'status' => 'success',
                'status_code' => $resp->getStatusCode(),
                'content_length' => strlen($resp->getContent()),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => array_slice(explode("\n", $e->getTraceAsString()), 0, 15),
            ], 500);
        }
    });

    // 1. Katalog & Detail Paket Wisata
    Route::get('/packages', [PackageController::class, 'index']);
    Route::get('/packages/categories', [PackageController::class, 'categories']);
    Route::get('/packages/{slugOrId}', [PackageController::class, 'show']);

    // 2. Cuaca Real-Time Dieng Plateau & Golden Sunrise
    Route::get('/weather', [WeatherController::class, 'current']);

    // 3. Simulator Biaya & Lead Generator
    Route::post('/calculator/estimate', [CalculatorController::class, 'estimate']);

    // 4. Informasi Platform, Kontak CS, dan Unit Bisnis
    Route::get('/site-info', [SiteInfoController::class, 'index']);

    // 5. Lokasi Titik Penjemputan Dinamis (Meeting Point Kalkulator)
    Route::get('/pickup-locations', [\App\Http\Controllers\Api\V1\PickupLocationController::class, 'index']);
});
