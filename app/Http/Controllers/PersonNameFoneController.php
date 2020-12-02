<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonNameFone;

class PersonNameFoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(PersonNameFone::query())->toJson();
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

        return PersonNameFone::create([
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
        return PersonNameFone::find($id);
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

        $personnamefone = PersonNameFone::find($id);
        $personnamefone->group = $request->group;
        $personnamefone->gid = $request->gid;
        $personnamefone->type = $request->type;
        $personnamefone->name = $request->name;
        $personnamefone->npfx = $request->npfx;
        $personnamefone->givn = $request->givn;
        $personnamefone->nick = $request->nick;
        $personnamefone->spfx = $request->spfx;
        $personnamefone->surn = $request->surn;
        $personnamefone->nsfx = $request->nsfx;
        $personnamefone->save();
        return $personnamefone;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personnamefonefone = PersonNameFone::find($id);
        if($personnamefonefone) {
            $personnamefonefone->delete();
            return "true";
        }
        return "false";
    }
}
