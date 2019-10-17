<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtItemDetail extends Model
{
    protected $primaryKey = 'et_id_id';
    protected $table = 'et_item_details';
    protected $fillable = array(
        'et_id_no',
        'et_id_product',
        'et_id_desc',
        'et_id_qty',
        'et_id_rate',
        'et_ad_total',
    );

    public $timestamps = true;
}
