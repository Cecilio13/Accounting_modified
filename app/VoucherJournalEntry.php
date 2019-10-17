<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherJournalEntry extends Model
{
    protected $primaryKey = 'journal_no';
    protected $table = 'voucher_journal_entry';
}
