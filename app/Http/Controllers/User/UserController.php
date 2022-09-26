<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use App\Enums\UserEnum;

class UserController extends Controller
{
    public function __construct(
        public UserService $userService,
    )
    {
        
    }
    public function update(UpdateUserRequest $request) {
        $user = Auth::user();
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'dob' => $request->dob,
            'gender' => $request->gender == UserEnum::WOMAN ? UserEnum::WOMAN : UserEnum::MAN,
        ];

    }
}
