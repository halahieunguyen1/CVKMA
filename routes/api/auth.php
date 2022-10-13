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
    Route::post('logoff', [AuthController::class, 'logoff']);
});
use Caxy\HtmlDiff\HtmlDiff;
use Caxy\HtmlDiff\HtmlDiffConfig;

Route::get('test', function () {
    $config = new HtmlDiffConfig();
    $config->setInsertSpaceInReplace(true);
    
    $config->setEncoding('UTF-8')
    ->setIsolatedDiffTags([])
    ->setSpecialCaseChars(array('.', ',', '(', ')', '\''))
    // ->setSpecialCaseChars([])
    ;
   
    $htmlDiff = HtmlDiff::create('02 a1 a2 a3 a5 a6 a8 ao ao ao ao ao ao a9', 'aaa a a1 a4 a3 a5 a7 a8 ao ao ao ao ao ao a10', $config);
    $content = $htmlDiff->build();
echo $content;
echo '<br/>';
    $htmlDiff = HtmlDiff::create('<i>Chuỗi số 1</i>', 'Chuỗi số 2.', $config);
    $content = $htmlDiff->build();
    return $content;
});


