<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\UserController;

Route::group(['middleware'=>[
        'auth:api',
        // 'encode-response',
        // 'decode-request'
    ]], function() {
    // Thông tin 1 User
    Route::get('user-info',function(Request $request) {
        return Auth::user()->formatInfo();
    });

    // Update thông tin cá nhân
    Route::post('update-user', [UserController::class, 'update']);
});


Route::group(['controller' => UserController::class], function() {
    // Thông tin 1 User
    Route::get('/lucid', 'testLucid');
});
