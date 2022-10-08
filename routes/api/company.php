<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\CompanyController;

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

Route::get('get-all', [CompanyController::class, 'getAll']);
Route::get('get-top-list/', [CompanyController::class, 'getTopList']);
Route::get('get-top/{topListId}', [CompanyController::class, 'getTop']);
Route::get('get-by-id/{id}', [CompanyController::class, 'getById']);

Route::group(['middleware'=>['auth:api']], function() {
    // Route::post('create', [CompanyController::class, 'create']);
    // Route::post('update', [CompanyController::class, 'update ']);
});


