<?php

namespace App\Http\Controllers\CV;

use App\Http\Controllers\Controller;
use App\Models\DataCv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvController extends Controller
{
    //
    public function __construct() {
    }

    public function search(Request $request) {
        $query = DataCv::query();
        $query->where('data->profile->email', 'like', '%cv_12467%');
        dd($query->get());
        return responseSuccess([
            'id' => 1,
        ]);
    }

    public function postCreate(Request $request)
    {
        $lang       = $request->get('lang', 'en');
        $data       = $request->get('data', '');
        $color      = $request->get('color_scheme') ?? '000000';
        $font      = $request->get('font') ?? 'roboto';
        $fontsize   = $request->get('font_size') ?? 'normal';
        $spacing    = $request->get('spacing') ?? 'normal';

        

        return response()->json([
            'status' => 'failed',
            'error'  => 'Save CV Failed',
        ]);
    }


}
