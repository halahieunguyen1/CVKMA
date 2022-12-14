<?php

namespace App\Models\Job;

use App\Enums\JobEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

class Job extends Model
{
    use HasFactory, Notifiable;

    protected $table='jobs';

    protected $guards = [];

    protected $timestampFalse = [
        'view',
    ];

    public function employer()
    {
        return $this->belongsTo('App\Models\Employer', 'employer_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company\Company', 'company_id', 'id');
    }

    public function cvApplies()
    {
        return $this->hasMany('App\Models\CvApply', 'job_id', 'id');
    }

    public function fields()
    {
        return $this->belongsToMany(
            Field::class,
            'job_fields',
            'job_id',
            'field_id',
            'id',
            'id',
        );
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'job_categories',
            'job_id',
            'category_id',
            'id',
            'id',
        );
    }

    public function jobCategories()
    {
        return $this->hasMany(JobCategory::class, 'job_id', 'id');
    }

    public function scopePublish($query)
    {
        $now = Carbon::now();
        return $query->where('publish_from', '<=', $now)
        ->where('publish_to', '>=', $now)
        ->where('is_publish', 1);
    }

    public function scopeManager($query)
    {
        return $query->whereIn('position_id', JobEnum::POSITION_MANAGER);
    }

    public function scopeHighsalary($query)
    {
        return $query->orderByRaw(
            "case when salary_type = 0 then salary_to ELSE salary_to * 22000 end desc"
        );
    }

    public function scopeInternship($query)
    {
        return $query->where('position_id', JobEnum::JOB_INTERSHIP);
    }

    public function strPosition()
    {
        if ($this->position_id) {
            return JobEnum::JOB_POSITION[$this->position_id];
        }
        return 'Kh??ng x??c ?????nh';
    }

    // ki???m tra xem tin tuy???n d???ng c???p b???c l??nh ?????o tr??? l??n kh??ng? (Tr?????ng ph??ng/ Ph?? ph??ng, Qu???n l??/ Gi??m s??t, Tr?????ng chi nh??nh, Ph?? gi??m ?????c, Gi??m ?????c)
    public function isLeaderPosition()
    {
        if ($this->position_id) {
            // value trong file config job_position
            return in_array($this->position_id, JobEnum::POSITION_MANAGER);
        }
        return false;
    }

    public static function boot() {
  
        parent::boot();
  
        static::updating(function(Job $job) {  
            $isUpdateTimeStamp = !empty(Arr::except($job->getDirty(), $job->timestampFalse));
            $job->timestamps = $isUpdateTimeStamp;
        });
    }

    public function isExpired()
    {
        return ($this->deadline < date('Y-m-d'));
    }

    public function isPublishDateExpired()
    {
        return $this->publish_to < date('Y-m-d H:i:s');
    }

}
