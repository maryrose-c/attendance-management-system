<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AttendanceApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Public:
| POST /api/login
| GET  /api/attendance
|
| Protected with Sanctum token:
| GET    /api/me
| POST   /api/logout
| POST   /api/attendance
| GET    /api/attendance/{attendance}
| PUT    /api/attendance/{attendance}
| PATCH  /api/attendance/{attendance}
| DELETE /api/attendance/{attendance}
|
*/

Route::post('/login', [AuthController::class, 'login'])
    ->name('api.login');

Route::get('/attendance', [AttendanceApiController::class, 'index'])
    ->name('api.attendance.index');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me'])
        ->name('api.me');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('api.logout');

    Route::apiResource('attendance', AttendanceApiController::class)
        ->except(['index'])
        ->names([
            'store' => 'api.attendance.store',
            'show' => 'api.attendance.show',
            'update' => 'api.attendance.update',
            'destroy' => 'api.attendance.destroy',
        ]);
});