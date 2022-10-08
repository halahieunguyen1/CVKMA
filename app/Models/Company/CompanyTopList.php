<?php

namespace App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\PersonTrait;

class CompanyTopList extends Model
{
    use HasFactory, Notifiable;

    protected $table='company_top_lists';

}
