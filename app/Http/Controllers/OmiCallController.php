<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as Request;
use App\Libs\HtmlDiff;
use App\Libs\HtmlDiffConfig;

class OmiCallController extends Controller
{
    public function index(Request $request) {
        return view('omicall');
    }

}
