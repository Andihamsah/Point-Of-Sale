<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class In extends Model
{
    protected $fillable = [
        'jumlah', 'id_item', 'id_store', 'catatan'
    ];
}
