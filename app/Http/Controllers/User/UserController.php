<?php

namespace App\Http\Controllers\User;

use App\Enums\Response\MessageEnum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use App\Enums\UserEnum;
use App\Features\User\GetUserHasDataCvFeature;
use Lucid\Units\Controller as UnitsController;

class UserController extends UnitsController
{
    public function __construct(
        public UserService $userService,
    )
    {
        
    }
    public function update(UpdateUserRequest $request)
    {
        [$isUpdate, $user] = $this->userService->update($request);
        if ($isUpdate) {
            return responseSuccess(data: $user->formatInfo());
        }
        return reponseError(message: MessageEnum::UPDATE_FAILD, statusCode: 404);
    }

    public function testLucid() {
        return view('omicall');
    }
}
