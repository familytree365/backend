<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Addr;

class AddrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(Addr::query())->toJson();
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
        $request->validate([
            'adr1' => 'required',
            'adr2' => 'required',
            'city' => 'required',
            'stae' => 'required',
            'post' => 'required',
            'ctry' => 'required'
        ]);

        return Addr::create([
            'adr1' => $request->adr1,
            'adr2' => $request->adr2,
            'city' => $request->city,
            'stae' => $request->stae,
            'post' => $request->post,
            'ctry' => $request->ctry
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Addr::find($id);
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
        $request->validate([
            'adr1' => 'required',
            'adr2' => 'required',
            'city' => 'required',
            'stae' => 'required',
            'post' => 'required',
            'ctry' => 'required'
        ]);

        $addr = Addr::find($id);
        $addr->adr1 = $request->adr1;
        $addr->adr2 = $request->adr2;
        $addr->city = $request->city;
        $addr->stae = $request->stae;
        $addr->post = $request->post;
        $addr->ctry = $request->ctry;
        $addr->save();
        return $addr;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $addr = Addr::find($id);
        if($addr) {
            $addr->delete();
            return "true";
        }
        return "false";
    }
}
