<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Response\MessageEnum;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;
use App\Services\CryptService;

class AuthController extends Controller
{
    //
    public function __construct(
        public AuthService $authService,
        public CryptService $cryptService,
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
            $aesKey = $this->cryptService->storeKeyAES($token['token']);
            $token['key'] = $aesKey;
            return responseSuccess(
                data: $token
            );
        }
        return reponseError(message: MessageEnum::LOGIN_FAILD, statusCode: 404);
    }

    public function changePassword(ChangePasswordRequest $request) {
        $newPassword = $request->new_password;
        if (!$this->authService->changePassword($newPassword)) {
            return reponseError(message: MessageEnum::BASE_FAILD, statusCode: 404);  
        }
        return responseSuccess(message: MessageEnum::CHANGE_PASSWORD_SUCCESS);  
    } 

    public function logoff() {
        Auth::logout();
        return response()->json([
            "status" => "success",
        ]);
    }
}
