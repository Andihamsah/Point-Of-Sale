<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'id_member', 'id_item', 'id_store', 'no_transaksi', 'jumlah'
    ];
}
