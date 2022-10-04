<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Job extends Model
{
    use HasFactory, Notifiable;

    protected $table='jobs';

    public function employer()
    {
        return $this->belongsTo('App\Models\Employer', 'employer_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
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
}
