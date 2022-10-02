<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\PersonTrait;

class Skill extends Model
{
    use HasFactory, Notifiable;

    protected $table='skills';

}
