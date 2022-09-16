<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable  implements JWTSubject, MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'first_name',
        'last_name',
        'address',
        'dob',
        'email',
        'phone',
        'password',
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
        'password',
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

    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: fn () =>  $this->first_name . ' ' . $this->last_name,
        );
    }

}
