<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\Skill;
use App\Traits\SeederTrait;
class SkillSeeder extends Seeder
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
            Skill::truncate();
            $this->now = now();
            $fields = $this->cursor();
            while (($field = $fields->current()) != null) {
                   $data = $this->insertData($field);
                   if ($data) $this->data[] = $data;
                   if (count($this->data) % 20 == 1) {
                        Skill::insert($this->data);
                        $this->data=[];
                   $fields->next();
                }
            }
    }
    public $index = 0;
    public function insertData($field) {
        $fieldInsert = [
            'id' => $field['id'],
            'name' => $field['name'],
        ];
        return $fieldInsert;
    }

    
}
