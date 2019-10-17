<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StSalesReceipt extends Model
{
    protected $primaryKey = 'st_s_id';
    protected $table = 'st_sales_receipts';
    protected $fillable = array(
        'st_s_id',
        'st_s_no',
        'st_s_product',
        'st_s_desc',
        'st_s_qty',
        'st_s_rate',
        'st_s_total',
        'st_p_method',
        'st_p_reference_no',
        'st_p_deposit_to',
        'st_p_amount'
    );

    public $timestamps = true;
}
