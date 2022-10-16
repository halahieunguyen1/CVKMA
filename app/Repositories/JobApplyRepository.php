<?php

namespace App\Repositories;

use App\Models\JobCvApply;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class JobApplyRepository extends BaseRepository
{
    public function getModel() {
            return JobCvApply::query();
    }

    public function query(Builder $query, $options): void
    {
        if ($options['user_uuid'] ?? null) {
            $query->where('user_uuid', $options['user_uuid']);
        }

        if ($options['id'] ?? null) {
            $query->where('id', $options['id']);
        }

        if ($options['cv_version_id'] ?? null) {
            $query->where('cv_version_id', $options['cv_version_id']);
        }

        if ($options['data_cv_id'] ?? null) {
            $query->where('data_cv_id', $options['data_cv_id']);
        }

        if ($options['job_id'] ?? null) {
            $query->where('job_id', $options['job_id']);
        }
    }

    public function create($options)
    {
        return JobCvApply::create($options);
    }
}
