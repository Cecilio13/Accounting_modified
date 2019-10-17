<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseTransactionNew extends Model
{
    protected $primaryKey = 'et_no';
    protected $table = 'expense_transactions_new';
}
