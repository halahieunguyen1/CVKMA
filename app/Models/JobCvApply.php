<?php

namespace App\Models;

use App\Enums\JobApplyEnum;
use App\Models\CvVersion\CvVersionTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JobCvApply extends Model
{
    use CvVersionTrait;
    use HasFactory, Notifiable;

    protected $table='job_cv_applies';

    protected $fillable = [
        'status',
        'viewed',
        'fullname',
        'email',
        'phone',
        'data_cv_id',
        'letter',
        'job_id',
        'user_uuid',
        'cv_version_id',
    ];

    protected $casts = [
        'deleted_at' => 'datetime', 
        'updated_at' => 'datetime',
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
        return $this->belongsTo('App\Models\User', 'user_uuid', 'uuid');
    }
    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id', 'id')->withTrashed();
    }

    public function employer()
    {
        return $this->belongsTo('App\Models\Employer', 'employer_id', 'id');
    }

    public function scopeIsValuable($query)
    {
        return $query
        ->whereIn('status', [JobApplyEnum::STATUS_VIEWED, JobApplyEnum::STATUS_INIT])
        ->whereHas('job', function ($q) {
            $q->publish();
        });
    }

    public static function boot() {
  
        parent::boot();
  
        static::creating(function(JobCvApply $jobApply) {  
            $jobApply->status = 0;
            $jobApply->viewed = 0;
        });
    }
}
