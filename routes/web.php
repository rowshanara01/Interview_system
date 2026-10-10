<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-email', [MailController::class, 'sendEmail']);

Route::get('/posts', [PostController::class, 'posts']);
