<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            new CompanySeeder(),
            new FieldSeeder(),
            new JobSeeder(),
            new EmployerSeeder(),
            new CitySeeder(),
            new SkillSeeder(),
            new CategorySeeder(),
            new JobCategorySeeder(),
        ];
        foreach ($arr as $item) {
            $item->run();
        }
    }
}
