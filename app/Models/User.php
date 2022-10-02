<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use App\Traits\PersonTrait; 

class User extends Authenticatable  implements JWTSubject, MustVerifyEmail
{
    use HasFactory, Notifiable;
    use PersonTrait;
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    protected $fillable = [
        'uuid',
        'created_at',
        'updated_at',
        'first_name',
        'last_name',
        'address',
        'dob',
        'email',
        'phone',
        'gender',
        'avatar',
        'type',
        'premium_end_at',
        'email_verified_at',
        'status',
        'admin_note',
        'admin_note_id',
        'admin_note_at',
        'ban_admin_id',
        'ban_note',
        'banned_at',
        'status_find_job',
        'job_type',
        'profession',
        'exp',
        'level',
        'salary',
        'english_level',
        'desire',
        'introduce',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table='users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function formatInfo() {
        $unFomated = [
            'admin_note',
            'admin_note_id',
            'admin_note_at',
            'ban_admin_id',
            'banned_at',
            'ban_note',
            'email_verified_at',
            'banned_at',
            'remember_token',
            'updated_at'
        ];
        foreach ($unFomated as $item) {
            unset($this->{$item});
        }
        return $this->attributes;
    }
}
