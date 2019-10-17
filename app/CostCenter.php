<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    protected $primaryKey = 'cc_no';
    protected $table = 'cost_center';
}
