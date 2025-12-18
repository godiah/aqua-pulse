<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DeviceController as AdminDeviceController;
use App\Http\Controllers\Admin\DeviceLogController as AdminDeviceLogController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:tenant'])
    ->name('dashboard');

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    // User Management Routes
    Route::resource('users', AdminUserController::class);

    // Device Management Routes
    Route::resource('devices', AdminDeviceController::class);

    // Device Log Routes
    Route::get('logs', [AdminDeviceLogController::class, 'index'])->name('logs.index');
    Route::get('logs/{log}', [AdminDeviceLogController::class, 'show'])->name('logs.show');
    Route::delete('logs/{log}', [AdminDeviceLogController::class, 'destroy'])->name('logs.destroy');
    Route::post('logs/clear-old', [AdminDeviceLogController::class, 'clearOld'])->name('logs.clear-old');
    Route::delete('logs/device/{device}', [AdminDeviceLogController::class, 'clearDevice'])->name('logs.clear-device');

    // Legacy register route (kept for backwards compatibility)
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
