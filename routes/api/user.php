<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\UserController;
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
Route::get('auth_fail',function() {
    reponseError(statusCode: 401);
})->name('login');
Route::post('register', [LoginController::class, 'register']);
Route::group(['middleware'=>['auth:user']], function() {
    Route::get('userInfo',function(Request $request) {
        return Auth::user();
    });
});

