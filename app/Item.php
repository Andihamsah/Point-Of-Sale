<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillacle = [
        'name_item', 'image', 'stock', 'id_store', 'buy_cost', 'sell_cost', 'id_kategory'
    ];
}
