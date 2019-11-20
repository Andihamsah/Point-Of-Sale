<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Out extends Model
{
    protected $fillable = [
        'jumlah', 'id_item', 'id_store', 'catatan'
    ];
}
