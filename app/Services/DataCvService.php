<?php


namespace App\Services;

use App\Repositories\CvRepository;
use App\Repositories\CvVersionRepository;
use App\Repositories\DataCvVersionRepository;
use Illuminate\Http\Request;

class DataCvService
{
    public function __construct(
        public CvRepository $cvRepository,
        public CvVersionRepository $cvVersionRepository,
        public DataCvVersionRepository $dataCvVersionRepository,
    ) {

    }

    public function getDataCv(Request $request)
    {
        $profile = $request->profile;
        $global = $request->global;
        $education_meta = $request->education_meta ?? 'Học vấn';
        $education = $request->education ?? [];
        $experience_meta = $request->experience_meta ?? 'Kinh nghiệm làm việc';
        $experience = $request->experience ?? [];
        $activity_meta = $request->activity_meta ?? 'Hoạt động';
        $activity = $request->activity ?? [];
        $certification_meta = $request->certification_meta ?? 'Chứng chỉ';
        $certification = $request->certification ?? [];
        $award_meta = $request->award_meta ?? 'Phần thưởng';
        $award = $request->award ?? [];
        $skillrate_meta = $request->skillrate_meta ?? 'Kĩ năng';
        $skillrate = $request->skillrate ?? [];
        return compact('profile','global','education_meta','education','experience_meta','experience','activity_meta','activity','certification_meta','certification','award_meta','award','skillrate_meta','skillrate',);

    }

   

    public function createCv($cvData)
    {
        $cv = $this->cvRepository->add($cvData);
        $dataCvVersion = $this->createDataCvVersion($cvData, $cv->data_cv_id);
        $createCvVersion = $this->createCvVersion($cvData, $dataCvVersion->id, $cv->data_cv_id);
        return $this->cvRepository->updateVersionCv($cv, $createCvVersion->id);
    }

    public function updateVersionCv($cv, $cvData)
    {
        $cvVersion = $this->cvVersionRepository->getCvVersionByHash($cvData, $cv->data_cv_id);
        if (!$cvVersion) {
            $dataCvVersion = $this->getDataCvVersion($cv->data_cv_id, $cvData);
            $cvVersion = $this->createCvVersion($cvData, $dataCvVersion->id, $cv->data_cv_id);
        }
        return $this->cvRepository->updateVersionCv($cv, $cvVersion->id);
    }

    public function getDataCvVersion($dataCvId, $cvData)
    {
        $dataCvVersion = $this->dataCvVersionRepository->getDataCvVersionByHash($cvData['data'], $dataCvId);
        if ($dataCvVersion) {
            return $dataCvVersion;
        }

        return $this->createDataCvVersion($cvData, $dataCvId);
    }

    public function createDataCvVersion($data, $dataCvId)
    {
        $dataCvVersionData = [
            'data' => $data['data'],
            'data_cv_id' => $dataCvId
        ];
        return $this->dataCvVersionRepository->add($dataCvVersionData);
    }

    public function createCvVersion($cvData, $dataCvVersionId, $dataCvId)
    {
        $cvVersionData = [
            'data_cv_id' => $dataCvId,
            'template_cv_id' => $cvData['template_cv_id'] ?? null,
            'data_cv_version_id' => $dataCvVersionId,
            'color_scheme' => $cvData['color_scheme'] ?? null,
            'fontsize' => $cvData['fontsize'] ?? 'normal',
            'spacing' => $cvData['spacing'] ?? 'normal',
            'font' => $cvData['font'] ?? '',
            'lang' => $cvData['lang'] ?? '',
            'data' => $cvData['data']
        ];

        return $this->cvVersionRepository->add($cvVersionData);
    }
    
}
