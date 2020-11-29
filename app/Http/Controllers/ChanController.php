<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chan;

class ChanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(Chan::query())->toJson();
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
            'time' => 'required'
        ]);

        return Chan::create([
            'group' => $request->group,
            'gid' => $request->gid,
            'date' => $request->date,
            'time' => $request->time
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
        return Chan::find($id);
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
            'time' => 'required'
        ]);

        $chan = Chan::find($id);
        $chan->group = $request->group;
        $chan->gid = $request->gid;
        $chan->date = $request->date;
        $chan->time = $request->time;
        $chan->save();
        return $chan;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chan = Chan::find($id);
        if($chan) {
            $chan->delete();
            return "true";
        }
        return "false";
    }
}
