<?php


namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserService
{


    public function __construct(
        public UserRepository $userRepo,
    ) {

    }

    public function create($data)
    {
        return match (true) {
            $data instanceof Request => $this->createFromRequest($data),
            default => null
        };
    }

    public function createFromRequest(Request $request)
    {
        $this->userRepo->create($request->all());
    }
}
