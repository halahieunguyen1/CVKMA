<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company\CompanyTopList;
use App\Models\Company\TopList;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            // new DataCvSeeder(),
            new CompanySeeder(),
            new FieldSeeder(),
            new JobSeeder(),
            new EmployerSeeder(),
            new CitySeeder(),
            new SkillSeeder(),
            new CategorySeeder(),
            new JobCategorySeeder(),
            new TopListSeeder(),
            new TopListSeeder(),
        ];
        foreach ($arr as $item) {
            $item->run();
        }
    }
}
