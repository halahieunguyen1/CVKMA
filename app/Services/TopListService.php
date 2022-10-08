<?php


namespace App\Services;

use Carbon\Carbon;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company\Company;
use App\Repositories\TopListRepository;

class TopListService
{


    public function __construct(
        public TopListRepository $topListRepo,
    ) {

    }

    public function getModel() {
        return $this->topListRepo->getModel();
    }
    
    public function getAll() {
        $query = $this->getModel();
        return $query->get();
    }

}
