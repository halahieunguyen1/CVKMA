<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;

class AuthController extends Controller
{
    //
    public function __construct(
        public UserService $userService
    )
    {

    }

    public function register(RegisterRequest $request){
        $this->userService->create($request);
    }
}
