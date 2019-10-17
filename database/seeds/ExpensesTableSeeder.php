<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ExpensesTableSeeder extends Seeder
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
                'expenses_show_items_table' => 'On',
                'expenses_track_expense_and_item_by_customer' => 'Off',
                'expenses_billable' => 'Off',
                'expenses_bill_payment_terms' => null,
                'expenses_use_purchase_order' => 'Off',
                'expenses_purchase_order_email_message' => 'Default email message sent with purchase orders',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
        );

        DB::table('settings_expenses')->insert($data);
    }
}
