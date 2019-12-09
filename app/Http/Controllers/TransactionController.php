<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\DetailTransaction;
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
        // $item = Item::find($request->id_item);
        $no_trx  =  'TRX-'.date('dmys').mt_rand(1000,9999);
        
        $Countitem = count($request->id_item);
        for ($i=0; $i < $Countitem; $i++) { 
            $id_item = $request->id_item[$i];
            $id_member = $request->no_member[$i];
            $id_store = $request->store;
            $jumlah = $request->total_barang[$i];
            $sub_total = $request->sub_total[$i];
            $total = $request->total;
            $pay = $request->bayar;
            $return = $request->kembalian;
            
            $data = array(
                'id_item'       => $id_item,
                'id_store'      => $id_store,
                'id_member'     => $id_member,
                'no_transaksi'  => $no_trx,
                'total_item'    => $jumlah,
                'sub_total'     => $sub_total,
                'total'         => $total,
                'pay'           => $pay,
                'return'        => $return
                
            );
            $transaksi = Transaction::create($data);
            // $dtltransaksi = DetailTransaction::insert($data);
            
            $data_barang = Item::where('id', $id_item)->get();
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
    public function show($transaksi)
    {
        return response()->json(Transaction::where('no_transaksi', $transaksi)
                                            ->select('*',  'transactions.id as id', 'items.id as id_item')
                                            ->join('items', 'transactions.id_item', '=', 'items.id')
                                            ->get());
        return response()->json(Transaction::where('id_member', $transaksi)
                                            ->select('*',  'transactions.id as id', 'members.id as id_member')
                                            ->join('members', 'transactions.id_member', '=', 'members.id')
                                            ->get());
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
        $transaksi = Transaction::where('no_transaksi',$id);
        
        if ($transaksi->delete()) {
            return response()->json(['msg' => "succes"]);
        }
        return response()->json(['msg' => "failed"]);
    }
}
