<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AdvanceTableSeeder extends Seeder
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
                'advance_first_month_of_fiscal_year' => 'January',
                'advance_first_month_of_tax_year' => 'January',
                'advance_accounting_method' => 'Accrual',
                'advance_close_book' => 'Off',
                'advance_tax_form' => 'Sole proprietor',
                'advance_enable_acc_number' => 'Off',
                'advance_track_classes' => 'Off',
                'advance_track_location' => 'Off',
                'advance_prefill_form' => 'On',
                'advance_apply_credit' => 'On',
                'advance_invoice_unbilled_activity' => 'Off',
                'advance_apply_bill_payment' => 'On',
                'advance_add_service_field' => 'Off',
                'advance_single_time_activity_billable' => 'On',
                'advance_language' => 'English',
                'advance_home_currency' => 'Philippine Peso',
                'advance_multi_currency' => 'Off',
                'advance_date_format' => 'MM/dd/yyyy',
                'advance_number_format' => '123,456.00',
                'advance_dup_cheque_num' => 'On',
                'advance_dup_bill_num' => 'Off',
                'advance_inactive_time' => '3',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
        );

        DB::table('settings_advance')->insert($data);
    }
}
