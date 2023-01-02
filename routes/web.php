<?php

use App\Http\Controllers\DuyetTinTuDong;
use App\Http\Controllers\OmiCallController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function () {

// $config->setIsolatedDiffTags(array(

// ));
 
return;
});
Route::get('diff', [DuyetTinTuDong::class, 'diff']);
Route::get('omicall', [OmiCallController::class, 'index']);