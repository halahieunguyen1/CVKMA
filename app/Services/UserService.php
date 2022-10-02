<?php


namespace App\Services;

use App\Enums\UserEnum;
use App\Http\Requests\User\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Repositories\EmployerRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{


    public function __construct(
        public UserRepository $userRepo,
        public EmployerRepository $employerRepo,
    ) {

    }

    public function update(UpdateUserRequest $request)
    {
        $user = Auth::user();
        $columUpdates = ['first_name','last_name','phone','address','dob','gender','level','salary','english_level','desire','introduce','job_type','profession','exp'];
        $data = [];
        foreach ($columUpdates as $column) {
            if ($request->$column) {
                $data[$column] = $request->$column;
            }
        }
        return [$this->userRepo->update($user, $data), $user];
    }
}
