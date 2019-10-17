<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StCreditNote extends Model
{
    protected $primaryKey = 'st_cn_id';
    protected $table = 'st_credit_notes';
    protected $fillable = array(
        'st_cn_id',
        'st_cn_no',
        'st_cn_product',
        'st_cn_desc',
        'st_cn_qty',
        'st_cn_rate',
        'st_cn_total',
        'st_p_method',
        'st_p_reference_no',
        'st_p_deposit_to',
        'st_p_amount'
    );

    public $timestamps = true;
}
