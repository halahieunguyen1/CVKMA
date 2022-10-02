<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\CompanyEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Company;
use PDO;
use App\Traits\SeederTrait;
class CompanySeeder extends Seeder
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
            Company::truncate();
            $this->now = now();
            $companies = $this->cursor();
            $piiCompanies = $this->piiCursor();
            while (($company = $companies->current()) != null && ($piiCompany = $piiCompanies->current()) != null) {
                if ($company['id'] > $piiCompany['company_id']) {
                    $piiCompanies->next();
                }

                if ($company['id'] < $piiCompany['company_id']) {
                    $companies->next();
                }

                if ($company['id'] == $piiCompany['company_id']) {
                   $data = $this->insertData($company, $piiCompany);
                   if ($data) $this->data[] = $data;
                   $companies->next();
                   $piiCompanies->next();
                }
            }
            Company::insert($this->data);
    }
    public $index = 0;
    public function insertData($company, $piiCompany) {
        $companyInsert = [
            'id' => $company['id'],
            'logo' => $company['logo'] ?? '',
            'cover' => $company['cover'] ?? '',
            'name' => $piiCompany['name'] ?? '',
            'size' => match($company['size']) {
                '1-9' | '10-24' => CompanyEnum::SIZE_VERY_SMALL,
                '25-99' => CompanyEnum::SIZE_SMALL,
                '100-499' => CompanyEnum::SIZE_MEDIUM,
                '500-1000' => CompanyEnum::SIZE_LARGE,
                default => CompanyEnum::SIZE_VERY_LARGE,
            },
            'short_description' => $company['short_description'] ?? '',
            'description' => $company['description'] ?? '',
            'website' => $company['website'] ?? '',
            'phone' => $company['phone'] ?? '',
            'email' => $company['email'] ?? '',
            'created_at' => $this->now,
            'updated_at' => $this->now,
        ];
        return $companyInsert;
    }

    
}
