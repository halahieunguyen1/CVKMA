<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\Job\JobCategory;
use App\Traits\SeederTrait;
class JobCategorySeeder extends Seeder
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
            JobCategory::truncate();
            $this->now = now();
            $jobCategories = $this->cursor();
            while (($jobCategory = $jobCategories->current()) != null) {
                   $data = $this->insertData($jobCategory);
                   if ($data) $this->data[] = $data;
                   if (count($this->data) % 20 == 1) {
                        JobCategory::insert($this->data);
                        $this->data=[];
                   $jobCategories->next();
                }
            }
    }
    public $index = 0;
    public function insertData($jobCategory) {
        $jobCategoryInsert = [
            'id' => $jobCategory['id'],
            'job_id' => $jobCategory['job_id'],
            'category_id' => $jobCategory['category_id'],
            'is_main' => $jobCategory['is_main'],
        ];
        return $jobCategoryInsert;
    }

    
}
