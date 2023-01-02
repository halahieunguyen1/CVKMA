<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\CompanyController;
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
    'controller' => CompanyController::class, 
], function () {

    Route::get('get-all', 'getAll');
    Route::get('get-by-id/{id}', 'getById');
    
    Route::group([
        'middleware' => [
            // 'encode-response'
        ]
    ], function() {
        Route::get('get-top-list/', 'getTopList');
        Route::get('get-top/{topListId}', 'getTop');
    });
});
Route::get('get-all-job/{id}', [JobController::class, 'getJobOfCompany']);




