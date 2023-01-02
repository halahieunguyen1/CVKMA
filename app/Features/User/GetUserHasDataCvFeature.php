<?php
namespace App\Features\User;

use App\Repositories\UserRepository;
use Lucid\Units\Feature;

class GetUserHasDataCvFeature extends Feature
{
    public function __construct()
    {
    }

    public function handle(UserRepository $userRepo) {
        $a = 1;
    }
}