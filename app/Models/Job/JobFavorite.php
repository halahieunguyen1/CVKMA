<?php

namespace App\Models\Job;

use App\Enums\JobEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

class JobFavorite extends Model
{
    use HasFactory, Notifiable;

    protected $table='job_favorites';

    protected $fillable = [
        'job_id',
        'user_uuid',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'id');
    }

}
