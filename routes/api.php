<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('send-email', [EmailController::class, 'sendEmail']);
Route::get('user', [UserController::class, 'show']);
Route::post('change-email', [UserController::class, 'changeEmail']);
Route::post('change-name', [UserController::class, 'changeName']);
Route::post('change-password', [UserController::class, 'changePassword']);
Route::post('change-description', [UserController::class, 'changeDescription']);
Route::get('books', [BookController::class, 'index']);
Route::post('book', [BookController::class, 'store']);
Route::get('book/{id}', [BookController::class, 'show']);
Route::put('book/{id}/edit', [BookController::class, 'edit']);
Route::delete('book/{id}/delete', [BookController::class, 'delete']);
