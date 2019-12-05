<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;


class ItemController extends Controller
{
    public function produk(Request $request) //produk yg sudah ada
    {
        $item = new Item;
        $item->item_code = $request->kode_barang;
        $item->name_item = $request->nama_barang;
        $item->image = base64_encode($request->image);
        $item->stock = $request->stock;
        $item->id_store = $request->store;
        $item->buy_cost = $request->harga_beli;
        $item->sell_cost = $request->harga_jual;
        $item->id_kategory = $request->kategori_id;

        if ($item->save()) {
            return response()->json(['massage' => "succes"]);            
        }
        return response()->json(['massage' => "failed"]);
    }
    
    public function updateproduk(Request $request, $id) //produk yg sudah ada
    {
        $item = Item::find($id);
        $item->name_item = $request->nama_barang;
        $item->image = base64_encode($request->image);
        $item->stock = $request->stock;
        $item->id_store = $request->store;
        $item->buy_cost = $request->harga_beli;
        $item->sell_cost = $request->harga_jual;
        $item->id_kategory = $request->kategori_id;
        
        if ($item->update()) {
            return response()->json(['massage' => "succes"]);            
        }
        return response()->json(['massage' => "failed"]);
    }
    
    public function show($toko)
    {
        $item = Item::where('id_store',$toko)
                    ->join('categories', 'items.id_kategory', '=', 'categories.id')
                    ->get();
        return response()->json($item);
    }
    
    public function destroy($id)
    {
        $item = Item::find($id);
        
        if ($item->delete()) {
            return response()->json(['massage' => "succes"]);            
        }
        return response()->json(['massage' => "failed"]);
    }
    
    public function beli(Request $request, $id) //beli produk yg sudah ada atau tambah produk
    {
        $beli = Item::find($id);
        $beli->stock += $request->stock;
        $beli->buy_cost = $request->harga_beli;
        $beli->sell_cost = $request->harga_jual; 
        // $beli->total_beli = $beli->stock * $beli->buy_cost;
        
        if ($beli->save()) {
            return response()->json(['massage' => "succes"]);
        }
        return response()->json(['massage' => "failed"]);
    }
}