<?php

declare(strict_types=1);

use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/register', [RegisterUserController::class, 'create']);
Route::get('/login', [SessionController::class, 'create']);
