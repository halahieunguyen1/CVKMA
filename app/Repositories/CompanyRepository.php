<?php

namespace App\Repositories;

use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CompanyRepository extends BaseRepository
{

    public function find($id) : Company | null
    {
        return Company::find($id);
    }
    public function getModel() {
            return Company::query();
    }

    public function query(Builder $query, $request) : void
    {
        if ($request->title) {
            $query->where('title', 'like', "%$request->title%");
        }
    }
}
