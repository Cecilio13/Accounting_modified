<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StInvoice extends Model
{
    protected $primaryKey = 'st_i_id';
    protected $table = 'st_invoice';
    protected $fillable = array(
        'st_i_id',
        'st_i_no',
        'st_i_product',
        'st_i_desc',
        'st_i_qty',
        'st_i_rate',
        'st_i_total',
        'st_p_method',
        'st_p_reference_no',
        'st_p_deposit_to',
        'st_p_amount'
    );

    public $timestamps = true;
}
