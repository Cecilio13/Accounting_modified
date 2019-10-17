<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array(
                'id' => '1',
                'setting_id' => '1',
                'company_name' => 'Sample Company Name',
                'company_legal_name' => 'Sample Legal Company Name',
                'company_business_id_no' => '00-000000',
                'company_tax_form' => 'Sample Tax Form',
                'company_industry' => 'Sample Industry',
                'company_email' => 'sample@mail.com',
                'company_customer_facing_email' => 'sample_customer@mail.com',
                'company_phone' => '0912345678',
                'company_website' => 'www.sample.com',
                'company_address' => 'sample_address',
                'company_customer_facing_address' => 'sample_customer_address',
                'company_legal_address' => 'sample_legal_address',
                'company_logo' => null,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
        );

        DB::table('settings_company')->insert($data);
    }
}
