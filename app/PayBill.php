<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayBill extends Model
{
    protected $primaryKey = 'pay_bill_no';
    protected $table = 'pay_bill';
}
