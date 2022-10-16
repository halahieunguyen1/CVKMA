<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cv\CvController;
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


Route::group(
    [
        'middleware'=>[
            'auth:api'
        ],
        'controller'=> CvController::class
    ], function() {
        Route::post('create', 'postCreate');
        Route::post('update', 'postUpdate');
        Route::get('get-all', 'getAllOfUser');
        Route::get('view-by-id/{id}', 'getById');
        
        Route::get('search', 'search');
    }
);


