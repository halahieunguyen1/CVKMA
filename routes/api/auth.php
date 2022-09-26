<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\AuthController;
// use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Auth::routes(['verify' => true]);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware'=>['auth:api']], function() {
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::post('update-info', [UserController::class, 'updateInfo']);

    Route::post('logoff', [AuthController::class, 'login']);
});


