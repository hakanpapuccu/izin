<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationsController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\FileShareController;


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
    
    // Chat Routes
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{user}', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
    Route::get('/chat/general', [App\Http\Controllers\ChatController::class, 'getGeneralMessages'])->name('chat.general');
    Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/conversations', [App\Http\Controllers\ChatController::class, 'getConversations'])->name('chat.conversations');

    // File Share Routes
    Route::get('/files', [FileShareController::class, 'index'])->name('files.index');
    Route::get('/files/create', [FileShareController::class, 'create'])->name('files.create');
    Route::post('/files', [FileShareController::class, 'store'])->name('files.store');
    Route::get('/files/{id}/download', [FileShareController::class, 'download'])->name('files.download');
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
