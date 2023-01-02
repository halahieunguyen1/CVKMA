<?php

namespace App\Http\Controllers\Job;

use App\Enums\JobApplyEnum;
use App\Enums\Response\MessageEnum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\JobApplyService;
use App\Services\JobService;
use Illuminate\Support\Facades\DB;

class JobApplyController extends Controller
{
    public function __construct(
        public JobApplyService $jobApplyService,
        public JobService $jobService,
    )
    {

    }
    
    public function postApply(Request $request)
    {
        $jobId = $request->input('job_id');
        $job = $this->jobService->find($jobId);
        if (!$job) {
            return reponseError(message: MessageEnum::JOB_NOT_EXISTS);
        }
        if ($job->isExpired() || $job->isPublishDateExpired()) {
            return reponseError(message: MessageEnum::JOB_IS_EXPIRED);
        }
        $userId = Auth::id();
        $latestApply = $this->jobApplyService->getLastApplyByUserAndJobId($userId, $jobId);
        if ($latestApply) {
            $latestApplyCreatedTime = time() - strtotime($latestApply->created_at);
            if ($latestApplyCreatedTime <= JobApplyEnum::RE_APPLY_WAIT_TIME) {
                return reponseError(message: sprintf(MessageEnum::LIMIT_TIME_APPLY, JobApplyEnum::RE_APPLY_WAIT_TIME_STR));
            }
        }
        $cvId = $request->input('cv_id');
        $letter = trim($request->input('letter'));
        $options = [
            'data_cv_id' => $cvId,
            'letter' => $letter,
            'job_id' => $jobId,
            'user_uuid' => Auth::id(),
        ];
        try {
            DB::beginTransaction();
            $result = $this->jobApplyService->apply($options);
            if ($result['message'] ?? null)
            {
                return reponseError(message: $result['message']);
            }
            DB::commit();
            return responseSuccess();
        } catch (\Exception $e) {
            DB::rollback();
            return reponseError(message: $e->getMessage(), statusCode: 404);
        }
    }

    public function getApply(Request $request)
    {
        $type = $request->input('type') ?? JobApplyEnum::GET_JOB_CURRENT_APPLY;
        $jobs = $this->jobApplyService->getJobApply($type);
        return responseSuccess(data: $jobs);
    }
}
