<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositRecord extends Model
{
    protected $primaryKey = 'deposit_record_no';
    protected $table = 'deposit_record';
}
