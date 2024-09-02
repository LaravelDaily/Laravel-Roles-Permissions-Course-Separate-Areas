<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\User;
use App\Http\Middleware\IsAdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route(
        auth()->user()->is_admin
            ? 'admin.tasks.index'
            : 'user.tasks.index'
    );
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(IsAdminMiddleware::class)
        ->group(function () {
            Route::resource('tasks', Admin\TaskController::class);
        });

    Route::prefix('user')
        ->name('user.')
        ->group(function () {
            Route::resource('tasks', User\TaskController::class);
        });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
