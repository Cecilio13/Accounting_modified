<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerEdit extends Model
{
    protected $primaryKey = 'customer_id';
    protected $table = 'customers_edits';
}
