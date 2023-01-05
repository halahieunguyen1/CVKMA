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
                $this->jobService->queryJobIT($query);
                break; 
            case config('entrypoint.job') . "/job-manager":
                $this->jobService->queryJobManager($query);
                break; 
            case config('entrypoint.job') . "/job-internship":
                $this->jobService->queryJobInternship($query);
                break;
            case config('entrypoint.job') . "/job-high-salary":
                $this->jobService->queryJobHighSalary($query);
                break;
            // case config('entrypoint.job') . "/job-manager":
            //     $this->jobService->queryJobIT($query, $request);
            //     break; 
        }
        $query->select('id', 'title', 'salary_from', 'salary_to', 'salary_type', 'deadline', 'quantity', 'position_id', 'company_id', 'description');
        $query->with([
            'company' => function ($q) {
                $q->select(['id', 'logo', 'name']);
            }
        ]);
        $jobs = $this->jobService->get($query, $request);
        return responseSuccess(data: $jobs);
    }

    public function getById($id, Request $request) {
        $job = $this->jobService->getDetail(jobId: $id);
        $this->jobService->incViewJob($job);
        return $job;
    }

    public function getJobOfCompany($companyId, Request $request)
    {
        $query = $this->jobService->getModel();
        $this->jobService->getByCompany($query,$companyId);
        $query->select('id', 'title', 'salary_from', 'salary_to', 'salary_type', 'deadline', 'quantity', 'position_id', 'company_id', 'description');
        $jobs = $this->jobService->get($query, $request);
        return responseSuccess(data: $jobs);
    }

    public function getJobAdvanced(Request $request)
    {
        $query = $this->jobService->getModel();
        $countApply = $request->input('count_apply', null);
        if ($countApply) {
            // $query->whereHas('cvApplies', fn ($q) => $q->havingRaw("count(*) > $countApply"))
            // ->withCount('cvApplies');
            $query->whereHas('cvApplies', fn ($q) => $q->havingRaw("count(*) > ?", [$countApply]))
            ->withCount('cvApplies');
        }
        $jobs = $this->jobService->get($query, $request);

        return responseSuccess(data: $jobs);
    }

}
