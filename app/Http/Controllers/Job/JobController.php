<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use App\Enums\UserEnum;

class JobController extends Controller
{
    public function __construct(
        public UserService $userService,
    )
    {

    }
    public function update(Request $request) {


    }
}
