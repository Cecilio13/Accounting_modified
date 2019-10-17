<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $primaryKey = 'customer_id';
    protected $table = 'customers';
    protected $fillable = array(
        'customer_id',
        'f_name',
        'l_name',
        'email',
        'company',
        'phone',
        'mobile',
        'fax',
        'display_name',
        'other',
        'website',
        'street',
        'city',
        'state',
        'postal_code',
        'country',
        'payment_method',
        'terms',
        'opening_balance',
        'as_of_date',
        'account_no',
        'business_id_no',
        'notes',
        'attachment'
    );

    public $timestamps = true;
}
