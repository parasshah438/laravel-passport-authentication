<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::controller(UserController::class)->middleware('auth:api')->group(function () {
    Route::get('profile', 'profile');
    Route::get('logout', 'logout');
});