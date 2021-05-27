<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $company = new Company();
        $company->name = 'new company';
        $company->current_tenant = '2';
        $company->reg_com_nr = 'abc123';
        $company->fiscal_code = 'asd123';
        $company->email = 'company@backend.com';
        $company->phone = '03331234567';
        $company->fax = '1-888-473-2963';
        $company->website = 'company.com';
        $company->bank = 'HBL';
        $company->bank_account = '82801235';
        $company->notes = 'Company notes';
        $company->pays_vat = '0';
        $company->status = '1';
        $company->save();

        for($i = 0; $i < 10; $i++){
            $company = new Company();
            $company->name = $faker->name;
            $company->current_tenant = $faker->randomNumber(2);
            $company->reg_com_nr = $faker->bothify('###???');
            $company->fiscal_code = $faker->unique()->randomNumber(6);
            $company->email = $faker->unique()->safeEmail;
            $company->phone = $faker->unique()->e164PhoneNumber;
            $company->fax = $faker->unique()->randomNumber(6);
            $company->website = $faker->url;
            $company->bank = $faker->name;
            $company->bank_account = $faker->bankAccountNumber;
            $company->notes = $faker->sentence;
            $company->pays_vat = $faker->randomElement(['0','1']);
            $company->status = $faker->randomElement(['0','1']);
            $company->save();
        }
    }
}
