<?php

namespace App\Repositories;

use App\Libs\Encrypt;
use App\Models\DataCv;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CvRepository
{
    public function find($id) : DataCv | null
    {
        return DataCv::find($id);
    }

    public function getModel()
    {
        return DataCv::query();
    }

    public function add($data)
    {
        $cv = new DataCV;

        $cv->user_uuid = $data['user_uuid'] ?? Auth::id();
        $cv->cv_id = Encrypt::cvUniqueId();
        $cv->private_key = Encrypt::cvUniqueId();
        $cv->color_scheme = $data['color_scheme'] ?? null;
        $cv->font = $data['font'] ?? 'default';
        $cv->lang = $data['lang'] ?? null;
        $cv->fontsize = $data['fontsize'] ?? null;
        $cv->spacing = $data['spacing'] ?? null;
        $cv->data = $data['data'] ?? null;
        $cv->tags = '';
        if ($cv->save()) return $cv;

        return null;
    }

    public function updateVersionCv($cv, $cvVersionId)
    {
        $cv->cv_version_id = $cvVersionId;
        $cv->save();
        return $cv;
    }

    public function query(Builder $query,  $option) : void
    {
        if ($option['user_uuid'] ?? null) {
            $query->where('user_uuid', $option['user_uuid']);
        }

        if ($option['data_cv_id'] ?? null) {
            $query->where('data_cv_id', $option['data_cv_id']);
        }
    }
}
