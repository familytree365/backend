<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonEvent;

class PersonEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(PersonEvent::query())->toJson();
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
            'person_id' => 'required',
            'title' => 'required',
            'type' => 'required',
            'attr' => 'required',
            'date' => 'required',
            'plac' => 'required',
            'phon' => 'required',
            'caus' => 'required',
            'age' => 'required',
            'agnc' => 'required',
            'places_id' => 'required',
            'description' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required'
        ]);

        return PersonEvent::create([
            'person_id' => $request->person_id,
            'title' => $request->title,
            'type' => $request->type,
            'attr' => $request->attr,
            'date' => $request->date,
            'plac' => $request->plac,
            'phon' => $request->phon,
            'caus' => $request->caus,
            'age' => $request->age,
            'agnc' => $request->agnc,
            'places_id' => $request->places_id,
            'description' => $request->description,
            'year' => $request->year,
            'month' => $request->month,
            'day' => $request->day
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
        return PersonEvent::find($id);
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
            'person_id' => 'required',
            'title' => 'required',
            'type' => 'required',
            'attr' => 'required',
            'date' => 'required',
            'plac' => 'required',
            'phon' => 'required',
            'caus' => 'required',
            'age' => 'required',
            'agnc' => 'required',
            'places_id' => 'required',
            'description' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required'
        ]);

        $personevent = PersonEvent::find($id);
        $personevent->person_id = $request->person_id;
        $personevent->title = $request->title;
        $personevent->type = $request->type;
        $personevent->attr = $request->attr;
        $personevent->date = $request->date;
        $personevent->plac = $request->plac;
        $personevent->phon = $request->phon;
        $personevent->caus = $request->caus;
        $personevent->agnc = $request->agnc;
        $personevent->places_id = $request->places_id;
        $personevent->description = $request->description;
        $personevent->year = $request->year;
        $personevent->month = $request->month;
        $personevent->day = $request->day;
        $personevent->save();
        return $personevent;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personevent = PersonEvent::find($id);
        if($personevent) {
            $personevent->delete();
            return "true";
        }
        return "false";
    }
}
