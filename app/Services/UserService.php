<?php


namespace App\Services;
use App\Repositories\UserRepository;
use App\Repositories\EmployerRepository;
use App\Models\User;

class UserService
{


    public function __construct(
        public UserRepository $userRepo,
        public EmployerRepository $employerRepo,
    ) {

    }

}
