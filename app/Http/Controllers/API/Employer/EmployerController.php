<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('api/v1/employer')]
class TestController extends Controller
{
    //
    public function __construct() {
    }

    #[GET('test')]
    public function test() {
        return response()->json([
            'status' => 1
        ]);
    }

    
}
