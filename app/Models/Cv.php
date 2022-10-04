<?php

namespace App\Models;

use App\Enums\CvEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

class Cv extends Model
{
    use HasFactory, Notifiable;

    protected $table='data_cvs';

    protected $guards = [];

    protected $timestampFalse = [
        'view',
    ];

    protected $casts = [
        'data' => 'array'
   ];

}
