<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WeaponController;
use App\Http\Controllers\Api\TmprfidsController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PersonnelsController;
use App\Http\Controllers\PersonnelsController as ControllersPersonnelsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('dashboard', [DashboardController::class, 'index']);
Route::get('dashboard/{id}', [DashboardController::class, 'show']);
Route::post('dashboard', [DashboardController::class, 'store']);
Route::put('dashboard/{id}', [DashboardController::class, 'update']);
Route::delete('dashboard/{id}', [DashboardController::class, 'destroy']);

Route::prefix('personnels')->group(function () {
    // GET /api/personnels - Menampilkan semua data personel
    Route::get('/', [PersonnelsController::class, 'index']);

    // POST /api/personnels - Menyimpan data personel baru
    Route::post('/', [PersonnelsController::class, 'store']);

    // GET /api/personnels/{id} - Menampilkan detail personel berdasarkan ID
    Route::get('/{id}', [PersonnelsController::class, 'show']);

    // PUT /api/personnels/{id} - Memperbarui data personel berdasarkan ID
    Route::put('/{id}', [PersonnelsController::class, 'update']);

    // DELETE /api/personnels/{id} - Menghapus data personel berdasarkan ID
    Route::delete('/{id}', [PersonnelsController::class, 'destroy']);
});

Route::prefix('tmprfids')->group(function () {
    // GET /api/tmprfids - Menampilkan semua data tmprfid
    Route::get('/', [TmprfidsController::class, 'index']);

    // POST /api/tmprfids - Menyimpan atau memperbarui data nokartu (timpa jika ada)
    Route::post('/', [TmprfidsController::class, 'store']);

    // GET /api/tmprfids/{id} - Menampilkan data tmprfid berdasarkan ID
    Route::get('/{id}', [TmprfidsController::class, 'show']);

    // PUT /api/tmprfids/{id} - Memperbarui data tmprfid berdasarkan ID
    Route::put('/{id}', [TmprfidsController::class, 'update']);

    // DELETE /api/tmprfids/{id} - Menghapus data tmprfid berdasarkan ID
    Route::delete('/{id}', [TmprfidsController::class, 'destroy']);
});

Route::prefix('weapons')->group(function () {
    // GET /api/weapons - Menampilkan semua data senjata
    Route::get('/', [WeaponController::class, 'index']);

    // POST /api/weapons - Menyimpan data senjata baru
    Route::post('/', [WeaponController::class, 'store']);

    // GET /api/weapons/{id} - Menampilkan detail senjata berdasarkan ID
    Route::get('/{id}', [WeaponController::class, 'show']);

    // PUT /api/weapons/{id} - Memperbarui data senjata berdasarkan ID
    Route::put('/{id}', [WeaponController::class, 'update']);

    // DELETE /api/weapons/{id} - Menghapus data senjata berdasarkan ID
    Route::delete('/{id}', [WeaponController::class, 'destroy']);
});
