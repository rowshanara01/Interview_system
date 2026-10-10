<?php

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BookController;
use App\Http\Controllers\admin\BookController as AdminBookController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::post('books', [BookController::class, 'store']);
    Route::get('books/nearby', [BookController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::middleware('admin')->group(function () {
        Route::get('admin/users', [UserController::class, 'index']);
        Route::get('admin/books', [AdminBookController::class, 'index']);
        Route::delete('admin/books/{id}', [AdminBookController::class, 'destroy']);
    });
});
