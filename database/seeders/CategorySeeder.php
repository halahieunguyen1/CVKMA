<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Traits\SeederTrait;
class CategorySeeder extends Seeder
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
            Category::truncate();
            $this->now = now();
            $categories = $this->cursor();
            while (($category = $categories->current()) != null) {
                   $data = $this->insertData($category);
                   if ($data) $this->data[] = $data;
                   if (count($this->data) % 20 == 1) {
                        Category::insert($this->data);
                        $this->data=[];
                   $categories->next();
                }
            }
    }
    public $index = 0;
    public function insertData($category) {
        $categoryInsert = [
            'id' => $category['id'],
            'name' => $category['name'],
            'alias' => $category['alias'],
        ];
        return $categoryInsert;
    }

    
}
