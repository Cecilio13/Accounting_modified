<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'settings_expenses';
    protected $fillable = array(
        'id',
        'setting_id',
        'expenses_show_items_table',
        'expenses_track_expense_and_item_by_customer',
        'expenses_billable',
        'expenses_bill_payment_terms',
        'expenses_use_purchase_order',
        'expenses_purchase_order_email_message'
    );

    public $timestamps = true;
}
