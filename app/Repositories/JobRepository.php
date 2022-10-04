<?php

namespace App\Repositories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class JobRepository extends BaseRepository
{
    public function getModel() {
            return Job::query();
    }

    public function query(Builder $query, Request $request) : void
    {
        if ($request->title) {
            $query->where('title', 'like', "%$request->title%");
        }

        if ($request->salary_type) {
            $query->whereSalaryType($request->salary_type);
        }

        // if ($request->salary_from) {
        //     $query->where('salary_to', '>=', $request->salary_from);
        // }

        // if ($request->salary_to) {
        //     $query->where('salary_from', '', $request->salary_from);
        // }

        // if ($request->exp_years_from) {
        //     $query->where('salary_from', '', $request->salary_from);
        // }

         // if ($request->exp_years_to) {
        //     $query->where('salary_to', '>=', $request->salary_from);
        // }

        if ($request->position_id) {
            $query->where('position_id', $request->position_id);
        }

    }

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
