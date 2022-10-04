<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\JobService;
use App\Enums\UserEnum;
use Illuminate\Support\Facades\URL;

class JobController extends Controller
{
    public function __construct(
        public JobService $jobService,
    )
    {

    }
    public function get(Request $request) {
        $query = $this->jobService->getModel();
        switch (URL::current()) {
            case config('entrypoint.job') . "/job-it":
                $this->jobService->queryJobIT($query, $request);
                break; 
            case config('entrypoint.job') . "/job-manager":
                $this->jobService->queryJobManager($query, $request);
                break; 
            case config('entrypoint.job') . "/job-internship":
                $this->jobService->queryJobInternship($query, $request);
                break;
            case config('entrypoint.job') . "/job-high-salary":
                $this->jobService->queryJobHighSalary($query, $request);
                break;
            // case config('entrypoint.job') . "/job-manager":
            //     $this->jobService->queryJobIT($query, $request);
            //     break; 
        }

        $jobs = $this->jobService->get($query, $request);
        return responseSuccess(data: $jobs);
    }

    public function getById($id, Request $request) {
        $job = $this->jobService->getDetail(jobId: $id);
        $this->jobService->incViewJob($job);
        return $job;
    }
}
