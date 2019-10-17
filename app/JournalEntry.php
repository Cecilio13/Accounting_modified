<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $primaryKey = 'je_id';
    protected $table = 'journal_entries';

    public $timestamps = true;
}
