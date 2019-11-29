<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    protected $fillable = ([
        "supliers", "alamat", "no_phone"
    ]);
}
