<?php


namespace App\Services;

use Carbon\Carbon;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company\Company;
use App\Repositories\CompanyRepository;

class CompanyService
{


    public function __construct(
        public CompanyRepository $companyRepo,
    ) {

    }

    public function getModel() {
        return $this->companyRepo->getModel();
    }
    
    public function get($query, Request $request) {
        $take = 10;
        $this->companyRepo->query($query, $request);

        $orderBy = match ($request->order_by) {
            default => 'id'
        };
        $asc = $request->asc ?? true;
        $this->companyRepo->orderBy($query, $orderBy, $asc);

        $page = $request->page ?? 0;
        $this->companyRepo->paginate($query, $page, $take);

        return [
            'companies' => $this->companyRepo->get($query),
            'count' => $this->companyRepo->count($query)
        ];
    }

    public function incViewCompany(Company $company) {
        $company->view = $company->view + 1;
        $company->save();
    }
}
