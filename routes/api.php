<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout',  'logout')->name('logout');
    });
});

Route::controller(UserController::class)->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', 'user')->name('getUser');
        Route::get('/user/{username}', 'username')->name('getUserByUsername');
        Route::get('/users', 'users')->name('getUsers');
    });
});

// Route::controller(UserController::class)->group(function () {
//     Route::get('/user/{id}', 'getUserById')->name('getUserById');
//     Route::post('/follow/{id}', 'follow')->name('follow');
//     Route::post('/unfollow/{id}', 'unfollow')->name('unfollow');
//     Route::get('/followers/{id}', 'followers')->name('followers');
//     Route::get('/following/{id}', 'following')->name('following');
// })->middleware('auth:sanctum');

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('posts', PostController::class);
// });
