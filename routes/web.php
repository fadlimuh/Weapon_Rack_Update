<?php

use App\Models\personnels;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeaponsController;
use App\Http\Controllers\TmprfidsController;
use App\Http\Controllers\PersonnelsController;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [StatusController::class, 'index'])->name('dashboard');


    Route::get('/board', [BoardController::class, 'index'])->name('board.index');

    Route::get('/personnels', [PersonnelsController::class, 'index'])->name('personnels.index');
    Route::get('/personnels/create', [PersonnelsController::class, 'create'])->name('personnels.create');
    Route::post('/personnels', [PersonnelsController::class, 'store'])->name('personnels.store');
    Route::get('/personnels/{id}', [PersonnelsController::class, 'show'])->name('personnels.show');
    Route::get('/personnels/{id}/edit', [PersonnelsController::class, 'edit'])->name('personnels.edit');
    Route::put('/personnels/{id}', [PersonnelsController::class, 'update'])->name('personnels.update');
    Route::delete('/personnels/{id}', [PersonnelsController::class, 'destroy'])->name('personnels.destroy');

    Route::get('/tmprfids', [TmprfidsController::class, 'index'])->name('tmprfids.index');
    Route::delete('/tmprfids/{nokartu}', [TmprfidsController::class, 'destroy'])->name('tmprfids.destroy');

    route::get('/weapons', [WeaponsController::class, 'index'])->name('weapons.index');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/{user}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{user}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');


});


require __DIR__.'/auth.php';
