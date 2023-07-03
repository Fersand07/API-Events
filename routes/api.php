<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function()
{
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
Route::apiResource('users', UserController::class);
Route::apiResource('events', EventController::class);
// Route::apiResource('users/{$id}/edit', UserController::class);

    // ->only(['store'])
    // ->except(['index']);
