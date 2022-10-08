<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class BaseRepository
{
    public abstract function query(Builder $query, Request $request) : void;

    public function orderBy(Builder $query, $orderBy, $asc = false) : void
    {
        $query->orderBy($orderBy, $asc ? 'asc' : 'desc');
    }

    public function paginate(Builder $query, $page, $take = 10) : void
    {
        $query->offset($page * $take)->limit($take);
    }

    public function get(Builder $query)
    {
        return $query->get();
    }

    public function count(Builder $query)
    {
        return $query->count();
    }
}
