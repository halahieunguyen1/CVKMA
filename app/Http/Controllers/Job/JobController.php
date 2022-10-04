<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\JobService;
use App\Enums\UserEnum;

class JobController extends Controller
{
    public function __construct(
        public JobService $jobService,
    )
    {

    }
    public function getAll(Request $request) {
        $query = $this->jobService->getModel();
        $jobs = $this->jobService->get($query, $request);
        return responseSuccess(data: $jobs);
    }

    public function jobIT(Request $request) {
        $query = $this->jobService->getModel();
        $this->jobService->queryJobIT($query, $request);
        $jobs = $this->jobService->get($query, $request);
        return responseSuccess(data: $jobs);
    }
}
