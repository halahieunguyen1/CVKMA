<?php

namespace App\Repositories;

use App\Models\CvVersion\DataCvVersion;

class DataCvVersionRepository
{
    public function add($data)
    {
        $dataCvVersion = new DataCvVersion();
        $dataCvVersion->data_cv_id = $data['data_cv_id'];
        $dataCvVersion->hash = $this->createHashData($data['data']);
        $dataCvVersion->data = $data['data'];
        $dataCvVersion->save();
        return $dataCvVersion;
    }

    private function createHashData($data)
    {
        return hex2bin(md5(json_encode($data)));
    }

    public function getDataCvVersionByHash($dataCv, $dataCvId)
    {
        $dataCvVersionModel = new DataCvVersion();
        $dataCvVersion = $dataCvVersionModel->where(['data_cv_id' => $dataCvId, 'hash' => $this->createHashData($dataCv)])->first();
        return $dataCvVersion;
    }
}
