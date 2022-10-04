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
        $jobs = $this->jobService->getAll($request);
    }
}
