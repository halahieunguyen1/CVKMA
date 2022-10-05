<?php
namespace App\Models\CvVersion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataCvVersion extends Model
{
    protected $masterConnection = 'cvo';
    protected $table = 'data_cv_versions';
}
