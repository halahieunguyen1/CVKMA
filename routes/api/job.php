<?php

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

Route::get('get-all', [JobController::class, 'getAll']);
Route::get('job-it', [JobController::class, 'jobIT']);
Route::get('get-by-id', [JobController::class, 'getById']);

Route::group(['middleware'=>['auth:api']], function() {
    // Route::post('create', [JobController::class, 'create']);
    // Route::post('update', [JobController::class, 'update ']);
});


