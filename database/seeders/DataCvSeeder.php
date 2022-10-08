<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\DataCv;
use App\Traits\SeederTrait;
class DataCvSeeder extends Seeder
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
            DataCv::truncate();
            $this->now = now();
            $data_cvs = $this->cursor();
            // $piiDataCvs = $this->piiCursor();
            while (($data_cv = $data_cvs->current()) != null) {
                   $data = $this->insertData($data_cv);
                   if ($data) $this->data[] = $data;
                   if (count($this->data) % 20 == 1) {
                        DataCv::insert($this->data);
                        $this->data=[];
                   }
                   $data_cvs->next();
            }
    }
    public $index = 0;
    public function insertData($data_cv) {
        $data_cvInsert = [
            'data_cv_id' => $data_cv['data_cv_id'],
            'cv_id' => $data_cv['cv_id'],
            'private_key' => $data_cv['private_key'],
            'user_id' => $data_cv['user_id'],
            'template_cv_id' => $data_cv['template_cv_id'],
            'data' => $data_cv['data'],
            'color_scheme' => $data_cv['color_scheme'],
            'fontsize' => $data_cv['fontsize'],
            'spacing' => $data_cv['spacing'],
            'cvtoken' => $data_cv['cvtoken'],
            'lang' => $data_cv['lang'],
            'public_view' => $data_cv['public_view'],
            'private_view' => $data_cv['private_view'],
            'tags' => $data_cv['tags'],
            'primary' => $data_cv['primary'],
            'font' => $data_cv['font'],
            'month_of_exp' => $data_cv['month_of_exp'],
            'graduate_year' => $data_cv['graduate_year'],
            'platform' => $data_cv['platform'],
            'is_profile' => $data_cv['is_profile'],
            'created_at' => $this->now,
            'updated_at' => $this->now,
        ];
        return $data_cvInsert;
    }


}
