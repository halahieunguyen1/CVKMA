<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company\TopList;
use App\Traits\SeederTrait;
class TopListSeeder extends Seeder
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
            TopList::truncate();
            $this->now = now();
            $topLists = $this->cursor();
            while (($topList = $topLists->current()) != null) {
                   $data = $this->insertData($topList);
                   if ($data) $this->data[] = $data;
                   if (count($this->data) % 20 == 1) {
                        TopList::insert($this->data);
                        $this->data=[];
                   $topLists->next();
                }
            }
    }
    public $index = 0;
    public function insertData($topList) {
        $topListInsert = [
            'id'    => $topList['id'],
            'title'    => $topList['title'],
            'description'    => $topList['description'],
            'og_image'    => $topList['og_image'],
            'banner'    => $topList['banner'],
            'created_at' => $this->now,
            'updated_at' => $this->now,
        ];
        return $topListInsert;
    }

    
}
