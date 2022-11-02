<?php

use App\Http\Controllers\Job\JobApplyController;
use App\Http\Controllers\Job\JobFavoriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Job\JobController;
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

Route::group([
    'controller' => JobController::class,
], function () {
    Route::get('get-all', 'get');
    Route::get('job-it', 'get');
    Route::get('job-manager', 'get');
    Route::get('job-internship', 'get');
    Route::get('job-high-salary', 'get');
    Route::get('get-by-id/{id}', 'getById');
    
    Route::group(['middleware'=>['auth:api']], function() {
        // Route::post('create', 'create);
        // Route::post('update', 'update);
    });
});

Route::group([
    'controller' => JobApplyController::class,
    'middleware' => ['auth:api'],
], function() {
    Route::post('apply', 'postApply');
    Route::get('get-job-applies', 'getApply');
});

Route::group([
    'controller' => JobFavoriteController::class,
    'middleware' => ['auth:api'],
], function() {
    Route::post('favorite/{id}', 'favorite');
    Route::post('unfavorite/{id}', 'unFavorite');
    Route::get('get-job-favorite', 'getFavorite');
});


