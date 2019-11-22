<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
{
    public function store(Request $request)
    {
        $item = Item::create([
            'name_item' => $request->nama_barang,
            'image' => base64_encode($request->image),
            'harga' => $request->harga,
            'stock' => $request->stock,
            'id_store' => $request->store,
            'buy_cost' => $request->harga_beli,
            'sell_cost' => $request->harga_jual,
            'id_kategory' => $request->kategory_id
        ]);
        if ($item->save()) {
            return response()->json(['massage' => "succes"]);            
        }
        return response()->json(['massage' => "failed"]);
    }
}
