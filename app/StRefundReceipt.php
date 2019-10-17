<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StRefundReceipt extends Model
{
    protected $primaryKey = 'st_r_id';
    protected $table = 'st_refund_receipts';
    protected $fillable = array(
        'st_r_id',
        'st_r_no',
        'st_r_product',
        'st_r_desc',
        'st_r_qty',
        'st_r_rate',
        'st_r_total',
        'st_p_method',
        'st_p_reference_no',
        'st_p_deposit_to',
        'st_p_amount'
    );

    public $timestamps = true;
}
