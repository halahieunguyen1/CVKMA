<?php

namespace App\Http\Controllers\CV;

use App\Http\Controllers\Controller;
use App\Models\Cv;
use Illuminate\Http\Request;

class CvController extends Controller
{
    //
    public function __construct() {
    }

    public function search(Request $request) {
        $query = Cv::query();
        $query->where('data->profile->email', 'like', '%cv_12467%');
        dd($query->get());
        return responseSuccess([
            'id' => 1,
        ]);
    }

}
