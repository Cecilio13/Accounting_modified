<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formstyle extends Model
{
    protected $primaryKey = 'cfs_id';
    protected $table = 'custom_form_style';

    public $timestamps = true;
}
