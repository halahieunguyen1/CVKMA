<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Company;
use PDO;
use App\Traits\SeederTrait;
use App\Models\User;
class UserSeeder extends Seeder
{
    use SeederTrait;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    private $data = [];
    private $address = [
        'Đồng Nguyên - Từ Sơn - Bắc Ninh',
        'Tân Hồng - Từ Sơn - Bắc Ninh',
        'Đình Bảng - Từ Sơn - Bắc Ninh',
        'Triều Khúc - Thanh Xuân - Hà Nội',
        'Chiến Thắng - Thanh Trì - Hà Nội',
        'Tiền An - Thành phố Bắc Ninh',

    ];
    public function run()
    {
        $this->userBefore = User::all()->pluck('uuid', 'email');
        User::truncate();
            $this->client = new \GuzzleHttp\Client();
            $this->now = now();
            $users = $this->cursor();
            $piiUsers = $this->piiCursor();
            while (($user = $users->current()) != null && ($piiUser = $piiUsers->current()) != null) {
                if ($user['user_id'] > $piiUser['pii_user_id']) {
                    $piiUsers->next();
                }

                if ($user['user_id'] < $piiUser['pii_user_id']) {
                    $users->next();
                }

                if ($user['user_id'] == $piiUser['pii_user_id']) {
                   $data = $this->insertData($user, $piiUser);
                   if ($data) $this->data[] = $data;
                   if ($this->index % 20 == 1 && $this->index > 20) {
                        sleep(3);
                        dump($data['uuid'], $this->index);
                        try {

                            User::insert($this->data);
                        } catch(\Exception $e) {

                        }
                        $this->data=[];
                    }
                   $users->next();
                   $piiUsers->next();
                }
            }
    }
    public $client;

    public $index = 0;
    public function insertData($user, $piiUser) {
        $uuid = $this->userBefore[$piiUser['unconfirm_email'] ?? $piiUser['email']] ?? null;
        if (!$uuid) {
            $res = $this->client->request('POST', 'https://cvnl.me/uuid/v1/user/hash', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                "body" => json_encode([
                    'account' => 'android_' . ($piiUser['unconfirm_email'] ?? $piiUser['email']),
                    'hash' => '123456'
                    ])
            ]);
            $body = json_decode((string)$res->getBody(), true);
            if ($body['error'] == true) {
                $res = $this->client->request('POST', 'https://cvnl.me/uuid/v1/user/create', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    "body" => json_encode([
                        'account' => 'android_' . ($piiUser['unconfirm_email'] ?? $piiUser['email']),
                        'hash' => '123456'
                        ])
                ]);
                $body = json_decode((string)$res->getBody(), true);
            } 
            $uuid = $body['data']['userInfo']['_id'] ?? null;
            $this->index++;
        }
       
        if (!$uuid) return;
        [$lastName, $firstName] =separateFullName($piiUser['fullname']);
        $userInsert = [
        'uuid' => $uuid,
        'first_name' => $firstName,
        'last_name' => $lastName,
        'address' => array_rand($this->address),
        'dob' => ($user['dob'] ?: 2000) . '-' . rand(1,12) . '-' . rand(1,28),
        'email' => $piiUser['unconfirm_email'] ?? $piiUser['email'] ?? "hieu". $this->index."$uuid@gmail.com",
        'phone' => '0' . rand(900000000, 99999999),
        'gender' => $user['gender'],
        'avatar' => $user['avatar'],
        'type' => $user['type'],
        'premium_end_at' => ($user['premium_end_at'] == '0000-00-00 00:00:00') ? $this->now  :$user['premium_end_at'],
        'email_verified_at' => $user['verified_at'],
        'status' => $user['status'],
        'admin_note' => $user['admin_note'],
        'admin_note_id' => $user['admin_note_author_id'],
        'admin_note_at' => $user['admin_note_date'],
        'ban_admin_id' => $user['banned_admin_id'],
        'ban_note' => $user['ban_note'],
        'banned_at' => $user['banned_at'],
        'status_find_job' => rand(0,1),
        'job_type' => $user['job_type'],
        'profession' => rand(1, 30),
        'exp' => $user['exp'],
        'level' => $user['level'],
        'salary' => $user['salary'],
        'english_level' => $user['english_level'],
        'desire' => $user['expectation'],
        'introduce' => $user['note'],
        'created_at' => $this->now,
        'updated_at' => $this->now,
        ];
        return $userInsert;
    }

    
}
