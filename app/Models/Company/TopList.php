<?php

namespace App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\TimeStampTrait;

class TopList extends Model
{
    use HasFactory, Notifiable;
    use TimeStampTrait;

    protected $table='top_lists';
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function companies()
    {
        return $this->belongsToMany('App\Models\Company\Company', 'company_top_lists', 'top_list_id', 'company_id');
    }


}
