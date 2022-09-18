<?php

namespace App\Repositories;

use App\Models\Employer;

class EmployerRepository
{
    public function create($options)
    {
        return Employer::create($options);
    }
}
