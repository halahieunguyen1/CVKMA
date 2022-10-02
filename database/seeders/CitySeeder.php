<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Traits\SeederTrait;
class CitySeeder extends Seeder
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
            City::truncate();
            $this->now = now();
            $fields = $this->cursor();
            while (($field = $fields->current()) != null) {
                   $data = $this->insertData($field);
                   if ($data) $this->data[] = $data;
                   if (count($this->data) % 20 == 1) {
                        City::insert($this->data);
                        $this->data=[];
                   $fields->next();
                }
            }
    }
    public $index = 0;
    public function insertData($field) {
        $fieldInsert = [
            'id' => $field['id'],
            'parent' => $field['parent'],
            'name' => $field['name'],
            'short_name' => $field['short_name'],
            'alias' => $field['alias'],
            'region' => $field['region'],
        ];
        return $fieldInsert;
    }

    
}
