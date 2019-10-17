<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherTransaction extends Model
{
    protected $primaryKey = 'tran_no';
    protected $table = 'voucher_transaction';
}
