<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Traits\SeederTrait;
class JobSeeder extends Seeder
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
            Job::truncate();
            $this->now = now();
            $jobs = $this->cursor();
            $piiJobs = $this->piiCursor();
            while (($job = $jobs->current()) != null && ($piiJob = $piiJobs->current()) != null) {
                if ($job['id'] > $piiJob['job_id']) {
                    $piiJobs->next();
                }

                if ($job['id'] < $piiJob['job_id']) {
                    $jobs->next();
                }

                if ($job['id'] == $piiJob['job_id']) {
                   $data = $this->insertData($job, $piiJob);
                   if ($data) $this->data[] = $data;
                   if (count($this->data) % 20 == 1) {
                        Job::insert($this->data);
                        $this->data=[];
                   }
                   $jobs->next();
                   $piiJobs->next();
                }
            }
    }
    public $index = 0;
    public function insertData($job, $piiJob) {
        $jobInsert = [
            'title' => $job['title'],
            'employer_id' => $job['employer_id'],
            'company_id' => $job['company_id'],
            'salary_from' => $job['salary_from'] ?? 0,
            'salary_to' => $job['salary_to'] ?? 100000000,
            'salary_type' => (($job['salary_to'] ?? 100000000) > 10000) ? 0 : 1,
            'publish_from' => $job['publish_from'] ?? $this->now,
            'publish_to' => $job['publish_to'] ?? $this->now,
            'deadline' => $job['deadline'],
            'is_publish' => $job['publish'],
            'description' => $job['description'],
            'job_requirement' => $job['job_requirement'],
            'job_benefit' => $job['job_benefit'],
            'view' => $job['view'],
            'quantity' => ($job['quantity'] > 127) ? 127 : $job['quantity'],
            'exp_years_from' => $job['exp_years_from'],
            'exp_years_to' => $job['exp_years_to'],
            'position_id' => $job['position_id'],
            'created_at' => $this->now,
            'updated_at' => $this->now,
        ];
        return $jobInsert;
    }

    
}
