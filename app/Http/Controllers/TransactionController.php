<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Store;
use App\Item;
use App\Member;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([Transaction::all()]);
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
        $item = Item::find($request->id_item)->first();
        $no_trx  =  'TRX-'.date('dmys');
        $transaksi = new Transaction;
        $transaksi->id_item = $item->id;
        $transaksi->id_member = $request->no_member;
        $transaksi->id_store = $request->store;
        $transaksi->no_transaksi = $no_trx;
        $transaksi->jumlah = $request->total_barang * $item->stock;
        // dd($transaksi);
        $transaksi->save();

        $barang = Item::find($request->id_item);
        $barang->stock =  $item->stock -= $request->total_barang;

        if ($barang->save()) {
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
    public function show($transaksi)
    {
        // dd($transaksi);
        return response()->json(Transaction::where('no_transaksi', $transaksi)->get());
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
