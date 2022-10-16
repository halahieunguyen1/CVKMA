<?php

namespace App\Models;

use App\Enums\CvEnum;
use App\Models\CvVersion\CvVersionTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

class DataCv extends Model
{
    use CvVersionTrait;
    use HasFactory, Notifiable;

    protected $table='data_cvs';

    protected $primaryKey='data_cv_id';

    protected $guards = [];

    protected $hidden = [
        'hash',
    ];

    protected $appends = [
        'title'
    ];

    protected $with = [
        'cvVersion.dataCvVersion'
    ];

    protected $timestampFalse = [
        'view',
    ];

    protected $casts = [
        'data' => 'array',
        'deleted_at' => 'datetime', 
        'updated_at' => 'datetime',
        'uptop_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_uuid', 'uuid');
    }

    public function toArray()
    {
        $data = parent::toArray();
        unset($data['cv_version']);
        return $data;
    }
}
