<?php


namespace App\Services;

use App\Enums\FieldEnum;
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
        $this->jobRepo->paginate($query, $page, $take);

        return [
            'jobs' => $this->jobRepo->get($query),
            'count' => $this->jobRepo->count($query)
        ];
    }

    public function queryJobIT(Builder $query) {
        $query->whereHas('fields', function ($q) {
            $q->where('fields.id',FieldEnum::JOB_IT);
        });
    }

   
}
