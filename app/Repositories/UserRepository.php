<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create($options)
    {
        return User::create($options);
    }

    public function update(User $user, $options)
    {
        foreach ($options as $key => $option) {
            $user->$key = $option;
        }
        return $user->save();
    }
}
