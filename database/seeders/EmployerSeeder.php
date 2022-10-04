<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\EmployerEnum;
use Illuminate\Database\Seeder;
use App\Models\Employer;
use App\Traits\SeederTrait;
class EmployerSeeder extends Seeder
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
            Employer::truncate();
            $this->now = now();
            $employers = $this->cursor();
            $piiEmployers = $this->piiCursor();
            while (($employer = $employers->current()) != null && ($piiEmployer = $piiEmployers->current()) != null) {
                if ($employer['id'] > $piiEmployer['employer_id']) {
                    $piiEmployers->next();
                }

                if ($employer['id'] < $piiEmployer['employer_id']) {
                    $employers->next();
                }

                if ($employer['id'] == $piiEmployer['employer_id']) {
                   $data = $this->insertData($employer, $piiEmployer);
                   if ($data) $this->data[] = $data;
                   if (count($this->data) % 20 == 1) {
                        Employer::insert($this->data);
                        $this->data=[];
                   }
                   $employers->next();
                   $piiEmployers->next();
                }
            }
    }
    public $index = 0;
    public function insertData($employer, $piiEmployer) {
        [$lastName, $firstName] =separateFullNameHasId($piiEmployer['fullname']);
        $employerInsert = [
            'id' => $employer['id'],
            'first_name' => $firstName,
            'last_name' => $lastName,
            'address' => array_rand($this->address),
            'dob' => (rand(1980,2005)) . '-' . rand(1,12) . '-' . rand(1,28),
            'email' => $piiEmployer['clean_mail'] ?? $piiEmployer['email'],
            'phone' => $piiEmployer['phone'],
            'password'  => $employer['password'],
            'gender'    => $employer['gender'] ?? EmployerEnum::MAN,
            'avatar'    => $employer['avatar'],
            'email_verified_at' => $employer['email_confirm_at'],
            'status'    => $employer['status'],
            'type'  => rand(0,1),
            'company_id'    => $employer['company_id'],
            'created_at'    => $this->now,
            'updated_at'    => $this->now,
        ];
        return $employerInsert;
    }


}
