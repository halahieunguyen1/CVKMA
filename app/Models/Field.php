<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\PersonTrait;

class Field extends Model
{
    use HasFactory, Notifiable;

    protected $table='fields';

}
