<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->group(function () {
    Route::get('user', [UserController::class, 'show']);
    Route::post('change-email', [UserController::class, 'changeEmail']);
    Route::post('change-name', [UserController::class, 'changeName']);
    Route::post('change-password', [UserController::class, 'changePassword']);
    Route::post('change-description', [UserController::class, 'changeDescription']);

    Route::middleware('can:viewAny,App\Models\User')->group(function () {
        Route::get('users', [UserController::class, 'index']);
        Route::put('user/{id}', [UserController::class, 'update']);
        Route::delete('user/{user}', [UserController::class, 'destroy']);
    });
});
