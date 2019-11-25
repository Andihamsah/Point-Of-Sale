<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
{
    public function store(Request $request)
    {
        $item =new Item;
        $item->name_item = $request->nama_barang;
        $item->image = base64_encode($request->image);
        $item->harga = $request->harga;
        $item->stock = $request->stock;
        $item->id_store = $request->store;
        $item->buy_cost = $request->harga_beli;
        $item->sell_cost = $request->harga_jual;
        $item->id_kategory = $request->kategory_id;        
        if ($item->save()) {
            return response()->json(['massage' => "succes"]);            
        }
        return response()->json(['massage' => "failed"]);
    }
}
