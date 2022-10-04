<?php


namespace App\Services;

use App\Repositories\JobRepository;
use App\Repositories\EmployerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;

class JobService
{


    public function __construct(
        public JobRepository $jobRepo,
    ) {

    }

    public function getAll(Request $request) {
        $query = $this->jobRepo->getModel();

    }
}
