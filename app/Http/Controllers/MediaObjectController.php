<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaObject;

class MediaObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(MediaObject::query())->toJson();
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
            'gid' => 'required',
            'group' => 'required',
            'titl' => 'required',
            'obje_id' => 'required',
            'rin' => 'required'
        ]);

        return MediaObject::create([
            'gid' => $request->gid,
            'group' => $request->group,
            'titl' => $request->titl,
            'obje_id' => $request->obje_id,
            'rin' => $request->rin
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
        return MediaObject::find($id);
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
            'gid' => 'required',
            'group' => 'required',
            'titl' => 'required',
            'obje_id' => 'required',
            'rin' => 'required'
        ]);

        $mediaobject = MediaObject::find($id);
        $mediaobject->gid = $request->gid;
        $mediaobject->group = $request->group;
        $mediaobject->titl = $request->titl;
        $mediaobject->obje_id = $request->obje_id;
        $mediaobject->rin = $request->rin;
        $mediaobject->save();
        return $mediaobject;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mediaobject = MediaObject::find($id);
        if($mediaobject) {
            $mediaobject->delete();
            return "true";
        }
        return "false";
    }
}
