<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

Route::get('/login', [LoginController::class, 'login']);
Route::post('/login', [LoginController::class, 'login']);

// Route::middleware('auth:sanctum')->group(function () {
    // category
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/{id}', [CategoryController::class, 'get']);
    Route::post('/category/save', [CategoryController::class, 'save']);
    Route::get('/category/delete/{id}', [CategoryController::class, 'delete']);

    // post
    Route::get('/post', [PostController::class, 'index']);
    Route::get('/post/{id}', [PostController::class, 'get']);
    Route::post('/post/save', [PostController::class, 'save']);
    Route::get('/post/delete/{id}', [PostController::class, 'delete']);

    // user
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'get']);
    Route::post('/user/save', [UserController::class, 'save']);
// });




