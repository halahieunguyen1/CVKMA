<?php

namespace App\Repositories;

use App\Models\CvVersion\CvVersion;
use TopCV\PII\Utils\PiiProcessor;

class CvVersionRepository
{
    public function add($data)
    {
        $cvVersion = new CvVersion();
        $cvVersion->data_cv_id = $data['data_cv_id'] ?? 0;
        $cvVersion->template_cv_id = $data['template_cv_id'] ?? null;
        $cvVersion->hash_all = $this->createHash($data) ?? null;
        $cvVersion->data_cv_version_id = $data['data_cv_version_id'] ?? 0;
        $cvVersion->color_scheme = $data['color_scheme'] ?? null;
        $cvVersion->fontsize = $data['fontsize'] ?? null;
        $cvVersion->spacing = $data['spacing'] ?? null;
        $cvVersion->font = $data['font'] ?? 'default';
        $cvVersion->lang = $data['lang'] ?? null;
        $cvVersion->save();
        if ($cvVersion) {
            return $cvVersion;
        }
        return null;
    }

    public function createHash($data)
    {
        $colorSchema = $data['color_scheme'] ?? "";
        $fontSize = $data['fontsize'] ?? "";
        $spacing = $data['spacing'] ?? "";
        $lang = $data['lang'] ?? "";
        $font = $data['font'] ?? "";
        $templateId = $data['template_id'] ?? "";
        $hash = hex2bin(md5($data['data'] . $colorSchema . $fontSize . $spacing . $lang . $font . $templateId));
        return $hash;
    }

    public function getCvVersionByHash($cvData, $dataCvId)
    {
        $cvVersionModel = new CvVersion();
        $cvVersion = $cvVersionModel->where(['hash_all' => $this->createHash($cvData), 'data_cv_id' => $dataCvId])->first();
        dd($cvVersion);
        return $cvVersion;
    }
}
