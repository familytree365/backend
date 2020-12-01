<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonAlia;

class PersonAliaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(PersonAlia::query())->toJson();
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
            'alia' => 'required',
            'import_confirm' => 'required'
        ]);

        return PersonAlia::create([
            'group' => $request->group,
            'gid' => $request->gid,
            'alia' => $request->alia,
            'import_confirm' => $request->import_confirm
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
        return PersonAlia::find($id);
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
            'alia' => 'required',
            'import_confirm' => 'required'
        ]);

        $personalia = PersonAlia::find($id);
        $personalia->group = $request->group;
        $personalia->gid = $request->gid;
        $personalia->alia = $request->alia;
        $personalia->import_confirm = $request->import_confirm;
        $personalia->save();
        return $personalia;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personalia = PersonAlia::find($id);
        if($personalia) {
            $personalia->delete();
            return "true";
        }
        return "false";
    }
}
