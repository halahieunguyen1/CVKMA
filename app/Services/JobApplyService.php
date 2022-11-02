<?php


namespace App\Services;

use App\Enums\CategoryEnum;
use App\Enums\JobApplyEnum;
use App\Enums\Response\MessageEnum;
use App\Repositories\JobRepository;
use Carbon\Carbon;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Job\Job;
use App\Repositories\CvRepository;
use App\Repositories\JobApplyRepository;
use Illuminate\Support\Facades\Auth;

class JobApplyService
{


    public function __construct(
        public JobRepository $jobRepo,
        public CvRepository $cvRepo,
        public DataCvService $cvService,
        public JobApplyRepository $jobApplyRepo,
    ) {

    }

    public function getModel() {
        return $this->jobApplyRepo->getModel();
    }
   public function getLastApplyByUserAndJobId($userId, $jobId)
   {
        $query = self::getModel();
        $options = [
            'user_uuid' => $userId,
            'job_id' => $jobId,
        ];
        $this->jobApplyRepo->query($query, $options);
        $this->jobApplyRepo->orderBy($query, 'id', 'desc');
        return $query->first();
   }

   public function getJobApply($type)
   {
        $query = self::getModel();
        $this->jobApplyRepo->query($query, [
            'user_uuid' => Auth::id(),
        ]);
        if ($type == JobApplyEnum::GET_JOB_CURRENT_APPLY) {
            $query->isValuable();
        }
        $this->jobApplyRepo->orderBy($query, 'created_at', 'desc');
        $query->with('job');
        $query->select(['created_at', 'user_uuid', 'job_id', 'id']);
        return $query->get();
   }

   public function apply($options)
   {
        $cvId = $options['data_cv_id'] ?? null;
        $cv = $this->cvService->getCvByIdOfUser($cvId);
        if (!$cv) {
            return [
                'message' => MessageEnum::CV_NOT_EXISTS,
            ];
        }
        $query = $this->jobApplyRepo->getModel();
        $this->jobApplyRepo->query($query, [
            'job_id' => $options['job_id'],
            'cv_version_id' => $cv->cv_version_id,
        ]);
        $apply = $query->first();
        if ($apply) return true;
        $options['cv_version_id'] = $cv->cv_version_id;
        $options['fullname'] = $cv->data->profile->fullname;
        $options['email'] = $cv->data->profile->email;
        $options['phone'] = $cv->data->profile->phone;
        return $this->jobApplyRepo->create($options);
   }
}
