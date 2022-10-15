<?php

namespace App\Http\Controllers\CV;

use App\Enums\Response\MessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cv\CreateCvRequest;
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
                return responseSuccess(data: $cv->toArray());
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return reponseError(message: MessageEnum::SAVE_CV_ERROR, statusCode: 404);
        }
        return reponseError(message: MessageEnum::SAVE_CV_ERROR, statusCode: 404);
    }


}
