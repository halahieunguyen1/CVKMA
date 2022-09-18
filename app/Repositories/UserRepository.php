<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create($options)
    {
        return User::create($options);
    }
}
