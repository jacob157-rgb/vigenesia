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
        // User Data
        Route::get('/user', 'user')->name('getUser');
        Route::get('/user/{username}', 'username')->name('getUserByUsername');
        Route::get('/users', 'users')->name('getUsers');
        // End User Data

        // Follow Unfollow
        Route::post('/follow/{username}', 'follow')->name('follow');
        Route::post('/unfollow/{username}', 'unfollow')->name('unfollow');
        // End Follow Unfollow

        // Followers Followings
        Route::get('/followers/{username}', 'followers')->name('followers');
        Route::get('/followings/{username}', 'followings')->name('followings');
        // End Followers Followings
    });
});

Route::controller(PostController::class)->group(
    function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/posts', 'index')->name('feeds');
            Route::post('/post', 'store')->name('post');
            Route::patch('/post/{id}', 'update')->name('postUpdate');
            Route::delete('/post/{id}', 'destroy')->name('postDestroy');
        });
    }
);
