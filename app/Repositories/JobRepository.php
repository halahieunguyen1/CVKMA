<?php

namespace App\Repositories;

use App\Models\Job;

class JobRepository extends BaseRepository
{

    public function getModel()
    {
       return new Job();
    }
}
