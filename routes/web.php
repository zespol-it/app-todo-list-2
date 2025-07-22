<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\SharedTaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Dashboard (alias przekierowujący do listy zadań)
Route::get('/dashboard', function () {
    return redirect()->route('tasks.index');
})->name('dashboard');

// Edycja profilu (placeholder)
Route::get('/profile', function () {
    return 'Edycja profilu nie jest dostępna w tej aplikacji.';
})->name('profile.edit');

// Uwierzytelnianie
require __DIR__.'/auth.php';

// Zadania (wymagają uwierzytelnienia)
Route::middleware('auth')->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::get('tasks-api', [TaskController::class, 'apiIndex'])->name('tasks.api');
    
    // Udostępnianie zadań
    Route::post('tasks/{task}/share', [SharedTaskController::class, 'create'])->name('tasks.share');
    Route::get('shared-tasks', [SharedTaskController::class, 'index'])->name('shared-tasks.index');
    Route::delete('shared-tasks/{sharedTask}', [SharedTaskController::class, 'destroy'])->name('shared-tasks.destroy');
});

// Publiczne wyświetlanie udostępnionych zadań (bez uwierzytelnienia)
Route::get('shared/{token}', [SharedTaskController::class, 'show'])->name('shared-tasks.show');
