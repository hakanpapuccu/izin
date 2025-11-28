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
    Route::resource('departments', App\Http\Controllers\DepartmentController::class);
    Route::resource('polls', App\Http\Controllers\PollController::class);
    
    // Platform Settings
    Route::get('settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
});


Route::middleware('auth')->group(function () {
    Route::get('/polls', [App\Http\Controllers\PollResponseController::class, 'index'])->name('polls.index');
    Route::get('/polls/{poll}', [App\Http\Controllers\PollResponseController::class, 'show'])->name('polls.show');
    Route::post('/polls/{poll}', [App\Http\Controllers\PollResponseController::class, 'store'])->name('polls.store');
    
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
    Route::post('/files/folder', [FileShareController::class, 'storeFolder'])->name('files.storeFolder');
    Route::get('/files/create', [FileShareController::class, 'create'])->name('files.create');
    Route::post('/files', [FileShareController::class, 'store'])->name('files.store');
    Route::get('/files/{id}/download', [FileShareController::class, 'download'])->name('files.download');
    Route::delete('/files/{id}', [FileShareController::class, 'destroy'])->name('files.destroy');
    Route::post('/files/{id}/move', [FileShareController::class, 'move'])->name('files.move');

    // Business Calendar Routes
    Route::get('/calendar', [App\Http\Controllers\BusinessEventController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/events', [App\Http\Controllers\BusinessEventController::class, 'getEvents'])->name('calendar.events');
    
    Route::middleware('admin')->group(function () {
        Route::post('/calendar/events', [App\Http\Controllers\BusinessEventController::class, 'store'])->name('calendar.store');
        Route::put('/calendar/events/{event}', [App\Http\Controllers\BusinessEventController::class, 'update'])->name('calendar.update');
        Route::delete('/calendar/events/{event}', [App\Http\Controllers\BusinessEventController::class, 'destroy'])->name('calendar.destroy');
    });
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
