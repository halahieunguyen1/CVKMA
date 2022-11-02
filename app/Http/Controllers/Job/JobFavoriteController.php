<?php

namespace App\Http\Controllers\Job;

use App\Enums\JobApplyEnum;
use App\Enums\Response\MessageEnum;
use App\Http\Controllers\Controller;
use App\Models\Job\Job;
use App\Models\Job\JobFavorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\JobService;
use Illuminate\Support\Facades\DB;

class JobFavoriteController extends Controller
{
    public function __construct(
        public JobService $jobService,
    )
    {

    }
    
    public function favorite($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return reponseError(message: MessageEnum::JOB_NOT_EXISTS, statusCode: 404);
        }

        if ($favorite = JobFavorite::firstOrCreate(array('job_id' => $id, 'user_uuid' => Auth::id())))
            return responseSuccess();
        return reponseError();
    }

    public function unFavorite($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return reponseError(message: MessageEnum::JOB_NOT_EXISTS, statusCode: 404);
        }

        if (JobFavorite::where('job_id', $id)->where('user_uuid', Auth::id())->delete());
            return responseSuccess();
        return reponseError();
    }

    public function getFavorite()
    {
        $jobIds = JobFavorite::where('user_uuid', Auth::id())->pluck('job_id');
        $jobs = Job::where('id', $jobIds)
        ->select('id', 'title', 'salary_from', 'salary_to', 'salary_type', 'deadline', 'quantity', 'position_id', 'company_id', 'description')
        ->with([
            'company' => function ($q) {
                $q->select(['id', 'logo', 'name']);
            }
        ])->get();
        return responseSuccess(data: $jobs);
    }

}
