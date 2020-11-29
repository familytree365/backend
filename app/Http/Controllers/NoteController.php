<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(Note::query())->toJson();
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
            'note' => 'required',
            'rin' => 'required',
            'name' => 'required',
            'description' => 'required',
            'is_active' => 'required',
            'type_id' => 'required',
            'group' => 'required'
        ]);

        return Note::create([
            'gid' => $request->gid,
            'note' => $request->note,
            'rin' => $request->rin,
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active,
            'type_id' => $request->type_id,
            'group' => $request->group
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
        return Note::find($id);
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
            'note' => 'required',
            'rin' => 'required',
            'name' => 'required',
            'description' => 'required',
            'is_active' => 'required',
            'type_id' => 'required',
            'group' => 'required'
        ]);

        $note = Note::find($id);
        $note->gid = $request->gid;
        $note->note = $request->note;
        $note->rin = $request->rin;
        $note->name = $request->name;
        $note->description = $request->description;
        $note->is_active = $request->is_active;
        $note->type_id = $request->type_id;
        $note->group = $request->group;
        $note->save();
        return $note;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::find($id);
        if($note) {
            $note->delete();
            return "true";
        }
        return "false";
    }
}
