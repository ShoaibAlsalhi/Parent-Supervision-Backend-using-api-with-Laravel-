<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DeviceController; // استدعاء الكونترولر

Route::prefix('v1')->group(function () {
    
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        
        Route::get('/user', function (\Illuminate\Http\Request $request) {
            return new \App\Http\Resources\UserResource($request->user());
        });

        // مسارات الأجهزة
        Route::get('/devices', [DeviceController::class, 'index']);
        Route::post('/devices', [DeviceController::class, 'store']);
        Route::delete('/devices/{id}', [DeviceController::class, 'destroy']);
    });
});