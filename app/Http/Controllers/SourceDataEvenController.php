<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SourceDataEven;

class SourceDataEvenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(SourceDataEven::query())->toJson();
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
            'group' => 'required',
            'gid' => 'required',
            'date' => 'required',
            'plac' => 'required'
        ]);

        return SourceDataEven::create([
            'group' => $request->group,
            'gid' => $request->gid,
            'date' => $request->date,
            'plac' => $request->plac,
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
        return SourceDataEven::find($id);
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
            'group' => 'required',
            'gid' => 'required',
            'date' => 'required',
            'plac' => 'required'
        ]);

        $sourcedataeven = SourceDataEven::find($id);
        $sourcedataeven->group = $request->group;
        $sourcedataeven->gid = $request->gid;
        $sourcedataeven->date = $request->date;
        $sourcedataeven->plac = $request->plac;
        $sourcedataeven->save();
        return $sourcedataeven;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sourcedataeven = SourceDataEven::find($id);
        if($sourcedataeven) {
            $sourcedataeven->delete();
            return "true";
        }
        return "false";
    }
}
