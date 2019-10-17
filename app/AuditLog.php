<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $primaryKey = 'log_id';
    protected $table = 'audit_logs';
    public $timestamps = true;
}
