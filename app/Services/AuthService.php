<?php


namespace App\Services;
use Illuminate\Support\Facades\Config;
use App\Enums\AuthEnum;
use App\Enums\EmployerEnum;
use App\Enums\UserEnum;
use App\Enums\TableEnum;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\EmployerRepository;
use Illuminate\Support\Facades\Auth;

class AuthService
{


    public function __construct(
        public UserRepository $userRepo,
        public EmployerRepository $employerRepo,
    ) {

    }

    public function create($data)
    {
        return match (true) {
            $data instanceof Request && $data->type_auth == AuthEnum::TYPE_USER => $this->createUserFromRequest($data),
            $data instanceof Request && $data->type_auth == AuthEnum::TYPE_EMPLOYER => $this->createEmployerFromRequest($data),
            default => null
        };
    }

    public function createUserFromRequest(Request $request)
    {
        $user = [];
        $user['email'] = $request->email;
        $user['phone'] = $request->phone;
        $user['first_name'] = $request->first_name;
        $user['last_name'] = $request->last_name;
        $user['password'] = $request->password;
        $user['address'] = $request->address;
        $user['dob'] = $request->dob;
        $user['gender'] = ($request->gender == UserEnum::MAN) ? UserEnum::MAN : UserEnum::WOMAN;
        return $this->userRepo->create($user);
    }

    public function createEmployerFromRequest(Request $request)
    {
        $user = [];
        $user['email'] = $request->email;
        $user['phone'] = $request->phone;
        $user['first_name'] = $request->first_name;
        $user['last_name'] = $request->last_name;
        $user['password'] = $request->password;
        $user['address'] = $request->address;
        $user['dob'] = $request->dob;
        $user['gender'] = ($request->gender == EmployerEnum::MAN) ? EmployerEnum::MAN : EmployerEnum::WOMAN;
        return $this->employerRepo->create($user);
    }

    public function login(Request $request)
    {
        $table = match (true) {
            $request->type_auth == AuthEnum::TYPE_EMPLOYER => TableEnum::EMPLOYER,
            $request->type_auth == AuthEnum::TYPE_ADMIN => TableEnum::ADMIN,
            default => TableEnum::USER,
        };
        Config::set('auth.providers.users.model' , "App\\Models\\$table");
        $optionsLogin = $this->formatLogin($request);
        $token = Auth::guard('employer')->attempt($optionsLogin, true);
        $result = [];
        if ($token) {
            $result = [
                'token' => $token
            ];
        }
        return $result;
    }

    private function formatLogin(Request $request) {
        $result = [
            'password' => $request->password,
        ];
        if ($request->email) {
            $result['email'] = $request->email;
        }

        if ($request->phone) {
            $result['phone'] = $request->phone;
        }

        return $result;
    }
}
