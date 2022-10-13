<?php

namespace App\Jobs;

use App\Models\CvVersion\CvVersion;
use App\Models\CvVersion\DataCvVersion;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateCvVersions implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $fromId;
    private $toId;
    private $model;
    private $primaryKey;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fromId, $toId, $model, $primaryKey)
    {
        dump($fromId);
        $this->fromId = $fromId;
        $this->toId = $toId;
        $this->model = $model;
        $this->primaryKey = $primaryKey;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $query = app($this->model)::query()
            ->where($this->primaryKey, '>=', $this->fromId)
            ->where($this->primaryKey, '<=', $this->toId)
            ->whereNotNull('data_cv_id')
            ->where('cv_version_id', 0)
            ->whereNotNull('hash');


        $dataCvs = $query->get();

        $this->processDataCv($dataCvs);
    }

    private function processDataCv($dataCvs)
    {
        if (!$dataCvs->count()) {
            return;
        }

        foreach ($dataCvs as $cv) {
            $cvVersion = $this->findCvVersionRecord($cv);
            if (!$cvVersion) {
                $cvVersion = $this->createNewCvVersion($cv);
            }
            $cv->cv_version_id = $cvVersion->id;
            dump($cv->cv_version_id);
            $cv->save();
        }
    }

    private function createNewCvVersion($cv)
    {
        $hasDataOnly = $this->createHashData($cv->getRawOriginal('data'));
        $dataCvVersion = DataCvVersion::query()
            ->where('data_cv_id', $cv->data_cv_id)
            ->where('hash', $hasDataOnly)
            ->first();
        if (!$dataCvVersion) {
            $dataCvVersion = $this->createDataCvVersion($cv);
        }
        $cvVersion = new CvVersion();
        $cvVersion->data_cv_id = $cv->data_cv_id;
        $cvVersion->template_cv_id = $cv->template_cv_id;
        $cvVersion->hash_all = $cv->hash;
        $cvVersion->data_cv_version_id = $dataCvVersion->id;
        $cvVersion->color_scheme = $cv->color_scheme;
        $cvVersion->fontsize = $cv->fontsize;
        $cvVersion->spacing = $cv->spacing;
        $cvVersion->font = $cv->font;
        $cvVersion->lang = $cv->lang;
        $cvVersion->save();
        return $cvVersion;
    }

    private function createDataCvVersion($cv)
    {
        $dataCvVersion = new DataCvVersion();
        $dataCvVersion->data_cv_id = $cv->data_cv_id;
        $dataCvVersion->hash = $this->createHashData($cv->getRawOriginal('data'));
        $dataCvVersion->data = $cv->getRawOriginal('data');
        $dataCvVersion->save();
        return $dataCvVersion;
    }



    private function createHashData($data)
    {
        return hex2bin(md5($data));
    }

    private function findCvVersionRecord($cv)
    {
        return CvVersion::query()
            ->where('data_cv_id', $cv->data_cv_id)
            ->where('hash_all', $cv->hash)
            ->first();
    }
}
