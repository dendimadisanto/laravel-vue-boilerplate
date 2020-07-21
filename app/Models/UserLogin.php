<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $table = 'userlogin';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
