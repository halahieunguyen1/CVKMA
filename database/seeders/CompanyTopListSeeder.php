<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company\CompanyTopList;
use App\Traits\SeederTrait;
class CompanyTopListSeeder extends Seeder
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
            CompanyTopList::truncate();
            $topLists = $this->cursor();
            while (($topList = $topLists->current()) != null) {
                   $data = $this->insertData($topList);
                   if ($data) $this->data[] = $data;
                   if (count($this->data) % 20 == 1) {
                        CompanyTopList::insert($this->data);
                        $this->data=[];
                   $topLists->next();
                }
            }
    }
    public $index = 0;
    public function insertData($topList) {
        $topListInsert = [
            'id'    => $topList['id'],
            'company_id'    => $topList['company_id'],
            'top_list_id'    => $topList['top_list_id'],
        ];
        return $topListInsert;
    }

    
}
