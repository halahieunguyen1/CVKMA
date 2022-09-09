<?php

namespace App\Http\Controllers\API\CV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;

#[Prefix('api/cv')]
class TestController extends Controller
{
    //
    public function __construct() {
    }

    #[Middleware('jwt.auth')]
    #[GET('test')]
    public function test() {
        return responseSuccess([
            'id' => 1,
        ]);
    }

    
}
