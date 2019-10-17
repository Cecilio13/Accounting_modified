<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StDelayedCredit extends Model
{
    protected $primaryKey = 'st_dcredit_id';
    protected $table = 'st_delayed_credits';
    protected $fillable = array(
        'st_dcredit_id',
        'st_dcredit_no',
        'st_dcredit_product',
        'st_dcredit_desc',
        'st_dcredit_qty',
        'st_dcredit_rate',
        'st_dcredit_total',
        'st_p_method',
        'st_p_reference_no',
        'st_p_deposit_to',
        'st_p_amount'
    );

    public $timestamps = true;
}
