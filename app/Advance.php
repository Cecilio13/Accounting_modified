<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'settings_advance';
    protected $fillable = array(
        'id',
        'setting_id',
        'advance_first_month_of_fiscal_year',
        'advance_first_month_of_tax_year',
        'advance_accounting_method',
        'advance_close_book',
        'advance_tax_form',
        'advance_enable_acc_number',
        'advance_track_classes',
        'advance_track_location',
        'advance_prefill_form',
        'advance_apply_credit',
        'advance_invoice_unbilled_activity',
        'advance_apply_bill_payment',
        'advance_add_service_field',
        'advance_single_time_activity_billable',
        'advance_language',
        'advance_home_currency',
        'advance_multi_currency',
        'advance_date_format',
        'advance_number_format',
        'advance_dup_cheque_num',
        'advance_dup_bill_num',
        'advance_inactive_time'
    );

    public $timestamps = true;
}
