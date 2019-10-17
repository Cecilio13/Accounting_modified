<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseTransaction extends Model
{
    protected $primaryKey = 'et_no';
    protected $table = 'expense_transactions';
    protected $fillable = array(
        'et_customer',
        'et_billing_address',
        'et_account',
        'et_payment_method',
        'et_terms',
        'et_date',
        'et_due_date',
        'et_bill_no',
        'et_memo',
        'et_attachment',
        'et_reference_no',
        'et_shipping_address',
        'et_shipping_to',
        'et_shipping_via',
        'et_type',
        'et_message',
        'et_email',
    );

    public $timestamps = true;
}