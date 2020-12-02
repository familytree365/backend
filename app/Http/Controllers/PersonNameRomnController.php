<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonNameRomn;

class PersonNameRomnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(PersonNameRomn::query())->toJson();
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
            'type' => 'required',
            'name' => 'required',
            'npfx' => 'required',
            'givn' => 'required',
            'nick' => 'required',
            'spfx' => 'required',
            'surn' => 'required',
            'nsfx' => 'required'
        ]);

        return PersonNameRomn::create([
            'group' => $request->group,
            'gid' => $request->gid,
            'type' => $request->type,
            'name' => $request->name,
            'npfx' => $request->npfx,
            'givn' => $request->givn,
            'nick' => $request->nick,
            'spfx' => $request->spfx,
            'surn' => $request->surn,
            'nsfx' => $request->nsfx
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
        return PersonNameRomn::find($id);
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
            'type' => 'required',
            'name' => 'required',
            'npfx' => 'required',
            'givn' => 'required',
            'nick' => 'required',
            'spfx' => 'required',
            'surn' => 'required',
            'nsfx' => 'required'
        ]);

        $personameromn = PersonNameRomn::find($id);
        $personameromn->group = $request->group;
        $personameromn->gid = $request->gid;
        $personameromn->type = $request->type;
        $personameromn->name = $request->name;
        $personameromn->npfx = $request->npfx;
        $personameromn->givn = $request->givn;
        $personameromn->nick = $request->nick;
        $personameromn->spfx = $request->spfx;
        $personameromn->surn = $request->surn;
        $personameromn->nsfx = $request->nsfx;
        $personameromn->save();
        return $personameromn;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personnameromn = PersonNameRomn::find($id);
        if($personnameromn) {
            $personnameromn->delete();
            return "true";
        }
        return "false";
    }
}
