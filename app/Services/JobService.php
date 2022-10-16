<?php


namespace App\Services;

use App\Enums\CategoryEnum;
use App\Repositories\JobRepository;
use App\Repositories\EmployerRepository;
use Carbon\Carbon;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;

class JobService
{


    public function __construct(
        public JobRepository $jobRepo,
    ) {

    }

    public function getModel() {
        return $this->jobRepo->getModel();
    }

    public function find($id) : Job|null
    {
        return $this->jobRepo->find($id);
    }

    public function get($query, Request $request) {
        $take = 10;
        $query->publish();
        $this->jobRepo->query($query, $request);

        $orderBy = match ($request->order_by) {
            default => 'id'
        };
        $asc = $request->asc ?? true;
        $this->jobRepo->orderBy($query, $orderBy, $asc);

        $page = $request->page ?? 0;
        $count = $this->jobRepo->count($query);
        $this->jobRepo->paginate($query, $page, $take);
        return [
            'jobs' => $this->jobRepo->get($query),
            'count' => $count,
        ];
    }

    public function queryJobIT(Builder $query) {
        $query->whereHas('jobCategories', function ($q) {
            $q->whereIn('category_id', [CategoryEnum::JOB_IT_HARDWARE, CategoryEnum::JOB_IT_SOFTWARE]);
        });
    }

    public function queryJobManager(Builder $query) {
        $query->manager();
    }

    public function queryJobInternship(Builder $query) {
        $query->internship();
    }

    public function queryJobHighSalary(Builder $query) {
        $query->internship();
    }

    public function getDetail(int $jobId) : Job
    {
        $job = Job::publish()->find($jobId);
        if (!$job) {

        }
        $job->load(['company']);
        return $job;
    }

    public function incViewJob(Job $job) {
        $job->view = $job->view + 1;
        $job->save();
    }

    public function getByCompany($query, $companyId)
    {
        $query->whereCompanyId($companyId);
    }
}
