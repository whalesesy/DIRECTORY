<?php

use App\Http\Controllers\Api\CountyLineController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\HealthCheckController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->group(function () {
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::get('/departments/{slug}', [DepartmentController::class, 'show']);
    Route::get('/county-lines', [CountyLineController::class, 'index']);
    Route::get('/health', [HealthCheckController::class, 'check']);
});
