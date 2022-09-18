<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Response\MessageEnum;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    //
    public function __construct(
        public AuthService $authService
    )
    {

    }

    public function register(RegisterRequest $request){
        $person = $this->authService->create($request);
        if ($person) {
            return responseSuccess();
        }
        return reponseError(statusCode: 404);
    }

    public function login(LoginRequest $request){
        $token = $this->authService->login($request);
        if ($token) {
            return responseSuccess(data: $token);
        }
        return reponseError(message: MessageEnum::LOGIN_FAILD, statusCode: 404);
    }
}
