<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationsController;
use App\Http\Controllers\AdminUserController;


Route::get('/',  [VacationsController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', AdminUserController::class);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile/{user?}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-image', [ProfileController::class, 'uploadImage'])->name('profile.upload-image');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('announcements', AnnouncementController::class);
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
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
    
    // Task Routes
    Route::resource('tasks', App\Http\Controllers\TaskController::class);
});

Route::get('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead')->middleware('auth');

require __DIR__.'/auth.php';
