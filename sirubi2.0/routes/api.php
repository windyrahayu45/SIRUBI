<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MasterController;

/*

|--------------------------------------------------------------------------
*/

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/refreshToken', [AuthController::class, 'refreshToken']);

Route::middleware('jwt')->group(function () {

    // 🔒 Protected routes (Harus pakai Authorization: Bearer TOKEN)
    Route::get('auth/profile', [AuthController::class, 'profile']);
    Route::post('auth/updatePassword', [AuthController::class, 'updatePassword']);
    Route::post('auth/updateProfile', [AuthController::class, 'updateProfile']);
    Route::get('data/init', [MasterController::class, 'init']);
    Route::post('data/tambahRumah', [MasterController::class, 'store']);
    Route::delete('data/deleteRumah', [MasterController::class, 'deleteRumah']);
});
