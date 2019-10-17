<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtAccountDetail extends Model
{
    protected $primaryKey = 'et_ad_id';
    protected $table = 'et_account_details';
    protected $fillable = array(
        'et_ad_no',
        'et_ad_product',
        'et_ad_desc',
        'et_ad_qty',
        'et_ad_rate',
        'et_ad_total',
    );

    public $timestamps = true;
}
