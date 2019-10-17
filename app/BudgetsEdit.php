<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetsEdit extends Model
{
    protected $primaryKey = 'budget_no';
    protected $table = 'budget_edits';
}
