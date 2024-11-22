<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TestController;

Route::get('/test', [TestController::class, 'index']);
Route::get('/create-token', [TestController::class, 'createToken'])->middleware('auth:sanctum');

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/category', [CategoryController::class, 'index']);
Route::get('/post', [PostController::class, 'index']);
Route::get('/post/{id}', [PostController::class, 'get']);

Route::middleware('auth:sanctum')->group(function () {
    // category
    Route::get('/category/{id}', [CategoryController::class, 'get'])->can('category-view');
    Route::post('/category/save', [CategoryController::class, 'save'])->can('category-create', 'category-update');
    Route::get('/category/delete/{id}', [CategoryController::class, 'delete'])->can('category-delete');

    // post
    Route::post('/post/save', [PostController::class, 'save'])->can('post-create');
    Route::get('/post/delete/{id}', [PostController::class, 'delete']);

    // user
    Route::get('/user', [UserController::class, 'index'])->can('user-pagination');
    Route::get('/user/{id}', [UserController::class, 'get'])->can('user-view');
    Route::post('/user/save', [UserController::class, 'save'])->can('user-create', 'user-update');
});
