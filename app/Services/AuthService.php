<?php


namespace App\Services;
use App\Enums\UserEnum;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\EmployerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use GuzzleHttp\Client;
class AuthService
{


    public function __construct(
        public UserRepository $userRepo,
        public EmployerRepository $employerRepo,
    ) {

    }

    public function changePassword($newPassword) {
        $client = new Client();
        $res = $client->request('POST', 'https://cvnl.me/uuid/v1/user/password', [
                'headers' => [
                'Content-Type' => 'application/json',
            ],
            "body" => json_encode([
                'uuid' => Auth::id(),
                'hash' => $newPassword
            ])
        ]);
        $body = json_decode((string)$res->getBody(), true);
        return !$body['error'];
    }

    public function create($data)
    {
        return match (true) {
            $data instanceof Request => $this->createUserFromRequest($data),
            default => null
        };
    }

    private function createAccount($email, $password) {
        $client = new Client();
        $res = $client->request('POST', 'https://cvnl.me/uuid/v1/user/create', [
                'headers' => [
                'Content-Type' => 'application/json',
            ],
            "body" => json_encode([
                'account' => 'L02' . $email,
                'hash' => $password
            ])
        ]);
        $body = json_decode((string)$res->getBody(), true);
        if ($body['error']) {
            // Xử lí lỗi
        }
        return $body['data']['userInfo']['_id'];
    }

    public function createUserFromRequest(Request $request)
    {
        $uuid = $this->createAccount($request->email, $request->password);
        $user = [];
        $user['uuid'] = $uuid;
        $user['email'] = $request->email;
        $user['phone'] = $request->phone;
        $user['first_name'] = $request->first_name;
        $user['last_name'] = $request->last_name;
        $user['address'] = $request->address;
        $user['dob'] = $request->dob;
        $user['gender'] = ($request->gender == UserEnum::MAN) ? UserEnum::MAN : UserEnum::WOMAN;
        return $this->userRepo->create($user);
    }


    public function login(LoginRequest $request)
    {
        $uuid = $this->loginAccount(email: $request->email, hash: $request->password);
        $token = Auth::guard('api')->attempt(['uuid' => $uuid, 'password' => '123456'], true);
        $result = [];
        if ($token) {
            $result = [
                'token' => $token
            ];
        }
        return $result;
    }

    private function loginAccount($email, $hash) {
        $client = new Client();
        $res = $client->request('POST', 'https://cvnl.me/uuid/v1/user/hash', [
                'headers' => [
                'Content-Type' => 'application/json',
            ],
            "body" => json_encode([
                'account' => 'L02' . $email,
                'hash' => $hash
            ])
        ]);
        $body = json_decode((string)$res->getBody(), true);
        if ($body['error']) {
            // Xử lí lỗi
        }
        return $body['data']['userInfo']['_id'];
    }

    private function formatLogin(Request $request) {
        $result = [
            'password' => $request->password,
        ];
        if ($request->email) {
            $result['email'] = $request->email;
        }
        return $result;
    }
}
