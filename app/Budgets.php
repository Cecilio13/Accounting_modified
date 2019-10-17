<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budgets extends Model
{
    protected $primaryKey = 'budget_no';
    protected $table = 'budget';
}
