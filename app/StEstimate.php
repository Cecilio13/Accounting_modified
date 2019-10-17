<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StEstimate extends Model
{
    protected $primaryKey = 'st_e_id';
    protected $table = 'st_estimates';
    protected $fillable = array(
        'st_e_id',
        'st_e_no',
        'st_e_product',
        'st_e_desc',
        'st_e_qty',
        'st_e_rate',
        'st_e_total',
        'st_p_method',
        'st_p_reference_no',
        'st_p_deposit_to',
        'st_p_amount'
    );

    public $timestamps = true;
}
