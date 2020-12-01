<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonAsso;

class PersonAssoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(PersonAsso::query())->toJson();
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
            'indi' => 'required',
            'import_confirm' => 'required'
        ]);

        return PersonAsso::create([
            'group' => $request->group,
            'gid' => $request->gid,
            'indi' => $request->indi,
            'import_confirm' => $request->import_confirm,
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
        return PersonAsso::find($id);
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
            'indi' => 'required',
            'import_confirm' => 'required'
        ]);

        $personasso = PersonAsso::find($id);
        $personasso->group = $request->group;
        $personasso->gid = $request->gid;
        $personasso->indi = $request->indi;
        $personasso->import_confirm = $request->import_confirm;
        $personasso->save();
        return $personasso;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personasso = PersonAsso::find($id);
        if($personasso) {
            $personasso->delete();
            return "true";
        }
        return "false";
    }
}
