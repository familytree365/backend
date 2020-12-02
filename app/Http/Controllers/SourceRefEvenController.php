<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SourceRefEven;

class SourceRefEvenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(SourceRefEven::query())->toJson();
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
            'even' => 'required',
            'role' => 'required'
        ]);

        return SourceRefEven::create([
            'group' => $request->name,
            'gid' => $request->name,
            'even' => $request->name,
            'role' => $request->name
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
        return SourceRefEven::find($id);
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
            'even' => 'required',
            'role' => 'required'
        ]);

        $sourcerefeven = SourceRefEven::find($id);
        $sourcerefeven->group = $request->group;
        $sourcerefeven->gid = $request->gid;
        $sourcerefeven->even = $request->even;
        $sourcerefeven->role = $request->role;
        $sourcerefeven->save();
        return $sourcerefeven;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sourcerefeven = SourceRefEven::find($id);
        if($sourcerefeven) {
            $sourcerefeven->delete();
            return "true";
        }
        return "false";
    }
}
