<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingCancelEntry extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'pending_cancel_entry';
}
