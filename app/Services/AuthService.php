<?php


namespace App\Services;
use App\Enums\UserEnum;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\EmployerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthService
{


    public function __construct(
        public UserRepository $userRepo,
        public EmployerRepository $employerRepo,
    ) {

    }

    public function checkPassword($password) {
        return Hash::check($password, Auth::user()->password);
    }

    public function changePassword($newPassword) {
        return User::whereId(Auth::id())->update([
            'password' => Hash::make($newPassword)
        ]);
    }

    public function create($data)
    {
        return match (true) {
            $data instanceof Request => $this->createUserFromRequest($data),
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


    public function login(Request $request)
    {
        $optionsLogin = $this->formatLogin($request);
        $token = Auth::guard('api')->attempt($optionsLogin, true);
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
