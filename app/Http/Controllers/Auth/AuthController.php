<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        
    }

    public function register(RegisterRequest $request){
        return 1;
    }
}
