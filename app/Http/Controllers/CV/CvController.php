<?php

namespace App\Http\Controllers\CV;

use App\Enums\Response\MessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cv\CreateCvRequest;
use App\Http\Requests\Cv\UpdateCvRequest;
use App\Models\DataCv;
use App\Services\DataCvService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CvController extends Controller
{
    //
    public function __construct(
        public DataCvService $cvService,
    ) {
    }

    public function search(Request $request) {
        $query = DataCv::query();
        $query->where('data->profile->email', 'like', '%cv_12467%');
        dd($query->get());
        return responseSuccess([
            'id' => 1,
        ]);
    }

    public function postCreate(CreateCvRequest $request)
    {
        $lang       = $request->get('lang', 'en');
        $color      = $request->get('color_scheme') ?? '000000';
        $font      = $request->get('font') ?? 'roboto';
        $fontsize   = $request->get('font_size') ?? 'normal';
        $spacing    = $request->get('spacing') ?? 'normal';
        $data       = json_encode($this->cvService->getDataCv($request));

        $cvData = compact('lang', 'color', 'font', 'fontsize', 'spacing', 'data');
        try {
            DB::beginTransaction();
            $cv = $this->cvService->createCv($cvData);
            if ($cv) {
                DB::commit();
                return responseSuccess(data: []);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return reponseError(message: MessageEnum::SAVE_CV_ERROR, statusCode: 404);
        }
        return reponseError(message: MessageEnum::SAVE_CV_ERROR, statusCode: 404);
    }

    public function postUpdate(UpdateCvRequest $request)
    {
        $cvId       = $request->cv_id;
        $cv = $this->cvService->getCvByIdOfUser($cvId);
        if (!$cv) {
            return reponseError(message: MessageEnum::CV_NOT_EXISTS);
        }
        $lang       = $request->get('lang', 'en');
        $color      = $request->get('color_scheme') ?? '000000';
        $font      = $request->get('font') ?? 'roboto';
        $fontsize   = $request->get('font_size') ?? 'normal';
        $spacing    = $request->get('spacing') ?? 'normal';
        $data       = json_encode($this->cvService->getDataCv($request));

        $cvData = compact('lang', 'color', 'font', 'fontsize', 'spacing', 'data');
        try {
            DB::beginTransaction();
            $cv = $this->cvService->updateVersionCv($cv, $cvData);
            if ($cv) {
                DB::commit();
                return responseSuccess(data: []);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return reponseError(message: MessageEnum::SAVE_CV_ERROR, statusCode: 404);
        }
        return reponseError(message: MessageEnum::SAVE_CV_ERROR, statusCode: 404);
    }

    public function getAllOfUser()
    {
        $cvs = $this->cvService->listCvOfUser();
        return responseSuccess(data: $cvs);
    }

    public function getById($id)
    {
        $cv = $this->cvService->getCvByIdOfUser($id);
        if (!$cv) {
            return reponseError(message: MessageEnum::CV_NOT_EXISTS);
        }
        return responseSuccess(data: $cv->toArray());
    }

}
