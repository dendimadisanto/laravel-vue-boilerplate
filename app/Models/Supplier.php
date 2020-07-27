<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Supplier extends Model
{
    //
    protected $table = 'supplier';
    protected $primaryKey = 'id';
    protected $fillable = ['supplier','address', 'phone'];
    public $timestamps = false;
}
