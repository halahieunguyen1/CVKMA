<?php

namespace App\Traits;

trait TimeStampTrait
{
    public function scopeDisableTimeStamp($query)
    {
        return $query->selectRaw('* EXCEPT created_at, updated_at');
    }
}
