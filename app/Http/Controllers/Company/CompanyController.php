<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Services\TopListService;

class CompanyController extends Controller
{
    public function __construct(
        public CompanyService $companyService,
        public TopListService $topListService,
    )
    {

    }
    public function getAll(Request $request) {
        $query = $this->companyService->getModel();
        $companies = $this->companyService->get($query, $request);
        return responseSuccess(data: $companies);
    }

    public function getTopList() {
        $topList = $this->topListService->getAll();
        return responseSuccess(data: $topList->toArray());
    }

    public function getTop($topListId, Request $request)
    {
        $query = $this->companyService->getModel();
        $companies = $this->companyService->get($query, $request);
        return responseSuccess(data: $companies);
    }
}
