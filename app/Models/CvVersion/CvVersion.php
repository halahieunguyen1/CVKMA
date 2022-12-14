<?php
namespace App\Models\CvVersion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CvVersion extends Model
{
    protected $table = 'cv_versions';
    protected $hidden = [
        'hash_all'
    ];
    protected $casts = [
        'data' => 'array',
    ];
    public function dataCvVersion()
    {
        return $this->belongsTo('App\Models\CvVersion\DataCvVersion', 'data_cv_version_id');
    }

    public function template()
    {
        return $this->belongsTo('\App\Models\TemplateCV', 'template_cv_id', 'template_cv_id');
    }
}
