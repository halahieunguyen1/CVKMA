<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JobCvApply extends Model
{
    use HasFactory, Notifiable;

    protected $table='job_cv_applies';

    protected $guards = [];


    protected $casts = [
        'deleted_at' => 'datetime', 
        'updated_at' => 'datetime',
        'uptop_at' => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo('\App\Models\Job', 'job_id', 'id');
    }

    public function cv()
    {
        return $this->belongsTo('\App\Models\DataCV', 'data_cv_id', 'data_cv_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'uuid');
    }

}
