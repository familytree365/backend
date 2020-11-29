<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citation;

class CitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(Citation::query())->toJson();
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
            'name' => 'required',
            'description' => 'required',
            'repository_id' => 'required',
            'volume' => 'required',
            'page' => 'required',
            'is_active' => 'required',
            'confidence' => 'required',
            'source_id' => 'required'
        ]);

        return Citation::create([
            'name' => $request->name,
            'description' => $request->description,
            'repository_id' => $request->repository_id,
            'volume' => $request->volume,
            'page' => $request->page,
            'is_active' => $request->is_active,
            'confidence' => $request->confidence,
            'source_id' => $request->source_id
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
        return Citation::find($id);
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
            'name' => 'required',
            'description' => 'required',
            'repository_id' => 'required',
            'volume' => 'required',
            'page' => 'required',
            'is_active' => 'required',
            'confidence' => 'required',
            'source_id' => 'required'
       ]);

        $citation = Citation::find($id);
        $citation->name = $request->name;
        $citation->description = $request->description;
        $citation->repository_id = $request->repository_id;
        $citation->volume = $request->volume;
        $citation->page = $request->page;
        $citation->is_active = $request->is_active;
        $citation->confidence = $request->confidence;
        $citation->source_id = $request->source_id;
        $citation->save();
        return $citation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $citation = Citation::find($id);
        if($citation) {
            $citation->delete();
            return "true";
        }
        return "false";
    }
}
