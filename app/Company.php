<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'settings_company';
    protected $fillable = array(
        'id',
        'setting_id',
        'company_name',
        'company_legal_name',
        'company_business_id_no',
        'company_tax_form',
        'company_industry',
        'company_email',
        'company_customer_facing_email',
        'company_phone',
        'company_website',
        'company_address',
        'company_customer_facing_address',
        'company_legal_address',
        'company_logo'
    );

    public $timestamps = true;
}
