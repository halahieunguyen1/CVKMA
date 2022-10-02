<?php


namespace App\Services;

use App\Repositories\JobRepository;
use App\Repositories\EmployerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobService
{


    public function __construct(
        public JobRepository $userRepo,
    ) {

    }

    public function getAll(Request $request) {
        // $job = 
    }
}
