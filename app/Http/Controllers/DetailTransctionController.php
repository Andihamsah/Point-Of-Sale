<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetailTransaction;

class DetailTransctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // $item = Item::find($request->id_item);
         $no_trx  =  'TRX-'.date('dmys').mt_rand(1000,9999);
        
         $Countitem = count($request->id_item);
         for ($i=0; $i < $Countitem; $i++) { 
             $id_item = $request->id_item[$i];
             $id_member = $request->no_member[$i];
             $id_store = $request->store;
             $jumlah = $request->total_barang[$i];
             $data_barang = Item::where('id', $id_item)->get();
             foreach ($data_barang as $barang) {
                 $total_harga = $jumlah * $barang->sell_cost ;                
             }
             $data = array(
                 'id_item' => $id_item,
                 'id_store' => $id_store,
                 'id_member' => $id_member,
                 'no_transaksi' => $no_trx,
                 'total_item' => $jumlah,
                 'total_cost' => $total_harga,
                 'created_at' => now(),
                 'updated_at' => now()
             );
             $transaksi = Transaction::insert($data);
             $dtltransaksi = DetailTransaction::insert($data);
             
             foreach ($data_barang as $db) {
                 $data2 = array(
                     'stock' => $db->stock - $jumlah,
                 );
                 $save = Item::where('id', $id_item)->update($data2);
             }
         } 
 
 
         if ($save) {
             return response()->json(['msg' => "succes"]);
         }
         return response()->json(['msg' => "failed"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
