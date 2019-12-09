<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    protected $fillable = [
        'id_member', 'id_item', 'id_store', 'no_transaksi', 'total_item', 'total_cost'
    ];
}
