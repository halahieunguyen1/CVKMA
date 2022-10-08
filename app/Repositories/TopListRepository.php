<?php

namespace App\Repositories;

use App\Models\Company\TopList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TopListRepository extends BaseRepository
{
    public function getModel() {
            return TopList::query();
    }

    public function query(Builder $query, Request $request) : void
    {
        // if ($request->title) {
        //     $query->where('title', 'like', "%$request->title%");
        // }

    }

   
}
