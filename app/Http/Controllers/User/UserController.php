<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class UserController extends Controller
{
    //

    public function register(Request $request){
        return response()->json([
            'status' => 'failed',
            'errors' => ['loser'=>['Tai khoan va mat khau khong chinh xac']]
        ]);
    }
}
