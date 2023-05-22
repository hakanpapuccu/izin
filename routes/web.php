<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationsController;



Route::get('/',  [VacationsController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(UserController::class)->group(function() {

    Route::get('/logout', 'destroy')->name('logout');
    Route::post('/login', 'store')->name('login');
});

Route::controller(VacationsController::class)->group(function() {
    
    Route::get('/vacations', 'index')->name('vacations');
    Route::post('vacations/add', 'add')->name('vacations.add');
    Route::get('vacations/verify/{id}' , 'verify')->name('vacations.verify');
    Route::get('vacations/reject/{id}' , 'reject')->name('vacations.reject');
});

require __DIR__.'/auth.php';
