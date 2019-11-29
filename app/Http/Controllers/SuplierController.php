<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suplier;

class SuplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([Suplier::all()]);
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
        $user = Suplier::create([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'no_phone' => $request->telp
        ]);

        if ($user->save()) {
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
        return response()->json([Suplier::find($id)->get()]);
         
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
        $user = Suplier::find($id);
        $user->name = $request->nama;
        $user->alamat = $request->alamat;
        $user->no_phone = $request->telp;
        
        if ($user->update()) {
            return response()->json(['msg' => "succes"]);
        }
        return response()->json(['msg' => "failed"]);
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Suplier::find($id);
        
        if ($user->delete()) {
            return response()->json(['msg' => "succes"]);
        }
        return response()->json(['msg' => "failed"]);

    }
}
