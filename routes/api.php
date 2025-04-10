<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TmprfidsController;
use App\Http\Controllers\Api\WeaponController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

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
