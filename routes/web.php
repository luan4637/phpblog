<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

Route::get('/', [UserController::class, 'index']);


// category
Route::get('/category', [CategoryController::class, 'index']);