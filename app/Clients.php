<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    //a_clients
    protected $primaryKey = 'clnt_id';
    protected $table = 'a_clients';
}
