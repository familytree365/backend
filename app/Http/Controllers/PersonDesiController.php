<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonDesi;

class PersonDesiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(PersonDesi::query())->toJson();
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
            'desi' => 'required'
        ]);

        return PersonDesi::create([
            'group' => $request->name,
            'gid' => $request->name,
            'desi' => $request->name
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
        return PersonDesi::find($id);
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
            'desi' => 'required'
        ]);

        $persondesi = PersonDesi::find($id);
        $persondesi->group = $request->group;
        $persondesi->gid = $request->gid;
        $persondesi->desi = $request->desi;
        $persondesi->save();
        return $persondesi;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $persondesi = PersonDesi::find($id);
        if($persondesi) {
            $persondesi->delete();
            return "true";
        }
        return "false";
    }
}
