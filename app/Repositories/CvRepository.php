<?php

namespace App\Repositories;

use App\Libs\Encrypt;
use App\Models\DataCv;
use Illuminate\Support\Facades\Auth;

class CvRepository
{
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

    
}
