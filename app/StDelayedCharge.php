<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StDelayedCharge extends Model
{
    protected $primaryKey = 'st_dc_id';
    protected $table = 'st_delayed_charges';
    protected $fillable = array(
        'st_dc_id',
        'st_dc_no',
        'st_dc_product',
        'st_dc_desc',
        'st_dc_qty',
        'st_dc_rate',
        'st_dc_total',
        'st_p_method',
        'st_p_reference_no',
        'st_p_deposit_to',
        'st_p_amount'
    );

    public $timestamps = true;
}
