<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
use App\Http\Middleware\RoleCheck;
use App\Models\Drug;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/get-drug/{id}', function ($id) {
        return Drug::find($id);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user', [RegisteredUserController::class, 'index'])->middleware(RoleCheck::class.':admin')->name('user.index');
    Route::get('/user/{id}', [RegisteredUserController::class, 'edit'])->middleware(RoleCheck::class.':admin')->name('user.edit');
    Route::patch('/user/{id}', [RegisteredUserController::class, 'update'])->middleware(RoleCheck::class.':admin')->name('user.update');
    Route::delete('/user/{id}', [RegisteredUserController::class, 'destroy'])->middleware(RoleCheck::class.':admin')->name('user.destroy');

    Route::get('/unit', [UnitController::class, 'index'])->middleware(RoleCheck::class.':admin,petugas-puskesmas,petugas-farmasi')->name('unit.index');
    Route::post('/unit', [UnitController::class, 'store'])->middleware(RoleCheck::class.':admin')->name('unit.store');
    Route::get('/unit/create', [UnitController::class, 'create'])->middleware(RoleCheck::class.':admin')->name('unit.create');
    Route::get('/unit/edit/{id}', [UnitController::class, 'edit'])->middleware(RoleCheck::class.':admin')->name('unit.edit');
    Route::patch('/unit/{id}', [UnitController::class, 'update'])->middleware(RoleCheck::class.':admin')->name('unit.update');
    Route::delete('/unit/{id}', [UnitController::class, 'destroy'])->middleware(RoleCheck::class.':admin')->name('unit.destroy');

    Route::get('/obat', [DrugController::class, 'index'])->middleware(RoleCheck::class.':admin,petugas-farmasi')->name('obat.index');
    Route::post('/obat', [DrugController::class, 'store'])->middleware(RoleCheck::class.':admin')->name('obat.store');
    Route::get('/obat/create', [DrugController::class, 'create'])->middleware(RoleCheck::class.':admin')->name('obat.create');
    Route::get('/obat/edit/{id}', [DrugController::class, 'edit'])->middleware(RoleCheck::class.':admin')->name('obat.edit');
    Route::patch('/obat/{id}', [DrugController::class, 'update'])->middleware(RoleCheck::class.':admin')->name('obat.update');
    Route::delete('/obat/{id}', [DrugController::class, 'destroy'])->middleware(RoleCheck::class.':admin')->name('obat.destroy');

    Route::get('/order', [OrderController::class, 'index'])->middleware(RoleCheck::class.':admin,petugas-puskesmas')->name('order.index');
    Route::post('/order', [OrderController::class, 'store'])->middleware(RoleCheck::class.':admin,petugas-puskesmas')->name('order.store');
    Route::get('/order/create', [OrderController::class, 'create'])->middleware(RoleCheck::class.':admin,petugas-puskesmas')->name('order.create');
});

require __DIR__.'/auth.php';
