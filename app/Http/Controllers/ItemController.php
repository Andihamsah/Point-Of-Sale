<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Category;

class ItemController extends Controller
{
    public function store(Request $request)
    {
        $item = new Item;
        $item->name_item = $request->nama_barang;
        $item->image = base64_encode($request->image);
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
    
    public function beli(Request $request, $id)
    {
        $beli = Item::find($id);
        $beli->stock += $request->stock;

        if ($beli->save()) {
            return response()->json(['massage' => "succes"]);
        }
        return response()->json(['massage' => "failed"]);
        
    }

    public function kategori(Request $request)
    {
        $kategori = Category::create([
            'name' => $request->kategori,
        ]);

        if ($kategori->save()) {
            return response()->json(['msg'=>"succes"]);
        }
        return response()->json(['msg'=>"failed"]);
    }
}
