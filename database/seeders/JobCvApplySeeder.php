<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\jobApplyEnum;
use Illuminate\Database\Seeder;
use App\Models\jobApply;
use App\Models\JobCvApply;
use App\Traits\SeederTrait;
class JobCvApplySeeder extends Seeder
{
    use SeederTrait;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    private $data = [];
    public function run()
    {
            JobCvApply::truncate();
            $this->now = now();
            $jobApplies = $this->cursor();
            $piijobApplies = $this->piiCursor();
            while (($jobApply = $jobApplies->current()) != null && ($piijobApply = $piijobApplies->current()) != null) {
                if ($jobApply['id'] > $piijobApply['job_cv_apply_id']) {
                    $piijobApplies->next();
                }

                if ($jobApply['id'] < $piijobApply['job_cv_apply_id']) {
                    $jobApplies->next();
                }

                if ($jobApply['id'] == $piijobApply['job_cv_apply_id']) {
                   $data = $this->insertData($jobApply, $piijobApply);
                   if ($data) $this->data[] = $data;
                   if (count($this->data) % 20 == 1) {
                        JobCvApply::insert($this->data);
                        $this->data=[];
                   }
                   $jobApplies->next();
                   $piijobApplies->next();
                }
            }
    }
    public $index = 0;
    public function insertData($jobApply, $piijobApply) {
        if ($jobApply['data_cv_id'])
        return [
            'id' => $jobApply['id'],
            'fullname' => $piijobApply['fullname'],
            'email' => $piijobApply['email'],
            'phone' => $piijobApply['phone'],
            'user_id'  => $jobApply['user_id'],
            'data_cv_id'    => $jobApply['data_cv_id'],
            'job_id' => $jobApply['job_id'],
            'status'    => $jobApply['status'],
            'company_id'    => $jobApply['company_id'],
            'employer_id'    => $jobApply['employer_id'],
            'data'    => $jobApply['data'] ?? json_encode(''),
            'color_scheme' => $jobApply['color_scheme'],
            'fontsize' => $jobApply['fontsize'],
            'spacing' => $jobApply['spacing'],
            'font' => $jobApply['font'] ?? 'default',
            'viewed' => $jobApply['viewed'],
            'letter' => $jobApply['letter'],
            'created_at'    => $this->now,
            'updated_at'    => $this->now,
        ];
    }


}
