<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SourceRef;

class SourceRefController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(SourceRef::query())->toJson();
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
            'sour_id' => 'required',
            'text' => 'required',
            'quay' => 'required',
            'page' => 'required'
        ]);

        return SourceRef::create([
            'group' => $request->group,
            'gid' => $request->gid,
            'sour_id' => $request->sour_id,
            'text' => $request->text,
            'quay' => $request->quay,
            'page' => $request->page
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
        return SourceRef::find($id);
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
            'sour_id' => 'required',
            'text' => 'required',
            'quay' => 'required',
            'page' => 'required'
        ]);

        $sourceref = SourceRef::find($id);
        $sourceref->group = $request->group;
        $sourceref->gid = $request->gid;
        $sourceref->sour_id = $request->sour_id;
        $sourceref->text = $request->text;
        $sourceref->quay = $request->quay;
        $sourceref->page = $request->page;
        $sourceref->save();
        return $sourceref;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sourceref = SourceRef::find($id);
        if($sourceref) {
            $sourceref->delete();
            return "true";
        }
        return "false";
    }
}
