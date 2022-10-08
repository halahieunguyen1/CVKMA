<?php

namespace App\Repositories;

use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CompanyRepository extends BaseRepository
{
    public function getModel() {
            return Company::query();
    }

    public function query(Builder $query, Request $request) : void
    {
        if ($request->title) {
            $query->where('title', 'like', "%$request->title%");
        }

    }

   
}
