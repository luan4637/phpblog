<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

Route::get('/', [UserController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/unauthenticated', [LoginController::class, 'unauthenticate']);

Route::middleware('auth')->group(function () {
    // category
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/{id}', [CategoryController::class, 'get']);
    Route::post('/category/save', [CategoryController::class, 'save']);
    Route::post('/category/delete', [CategoryController::class, 'delete']);

    // post
    Route::get('/post', [PostController::class, 'index']);
    Route::get('/post/{id}', [PostController::class, 'get']);
    Route::post('/post/save', [PostController::class, 'save']);
    Route::post('/post/delete', [PostController::class, 'delete']);
});




