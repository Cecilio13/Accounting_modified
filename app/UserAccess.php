<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    protected $primaryKey = 'user_id';
    protected $table = 'users_access_restrictions';
}
