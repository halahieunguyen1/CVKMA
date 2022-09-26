<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\PersonTrait;

class Employer extends Model
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
}
