<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\AttendanceController;

// Student Routes
Route::apiResource('students', StudentController::class);

// Attendance Routes
Route::prefix('attendance')->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
    Route::post('/', [AttendanceController::class, 'store']);
    Route::post('/bulk', [AttendanceController::class, 'bulkStore']);
    Route::get('/report/monthly', [AttendanceController::class, 'monthlyReport']);
    Route::get('/statistics', [AttendanceController::class, 'statistics']);
});
