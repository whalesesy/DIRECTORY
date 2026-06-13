<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CountyLineController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\StaffController;
use Illuminate\Support\Facades\Route;

// Redirect root to frontend or admin login
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Admin Authentication Routes
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Protected Admin Panel Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/updates', [DashboardController::class, 'updates'])->name('dashboard.updates');
    
    Route::resource('departments', DepartmentController::class);
    Route::resource('staff', StaffController::class);
    Route::resource('county-lines', CountyLineController::class);
});
