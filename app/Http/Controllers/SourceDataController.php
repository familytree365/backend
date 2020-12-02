<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SourceData;

class SourceDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(SourceData::query())->toJson();
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
            'text' => 'required',
            'agnc' => 'required'
        ]);

        return SourceData::create([
            'group' => $request->group,
            'gid' => $request->gid,
            'date' => $request->date,
            'text' => $request->text,
            'agnc' => $request->agnc
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
        return SourceData::find($id);
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
            'text' => 'required',
            'agnc' => 'required'
        ]);

        $sourcedata = SourceData::find($id);
        $sourcedata->group = $request->group;
        $sourcedata->gid = $request->gid;
        $sourcedata->date = $request->date;
        $sourcedata->text = $request->text;
        $sourcedata->agnc = $request->agnc;
        $sourcedata->save();
        return $sourcedata;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sourcedata = SourceData::find($id);
        if($sourcedata) {
            $sourcedata->delete();
            return "true";
        }
        return "false";
    }
}
