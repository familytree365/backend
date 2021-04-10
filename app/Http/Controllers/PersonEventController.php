<?php

namespace App\Http\Controllers;

use App\Models\PersonEvent;
use Illuminate\Http\Request;

class PersonEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = PersonEvent::query();

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['converted_date', 'year', 'month', 'day', 'type', 'attr', 'plac', 'addr_id', 'phon', 'caus', 'age', 'agnc', 'adop', 'adop_famc', 'person_id', 'title', 'date', 'description', 'places_id'];
            $search_term = json_decode($request->searchTerm)->searchTerm;
            if (! empty($search_term)) {
                $searchQuery = '%'.$search_term.'%';
                foreach ($columnsToSearch as $column) {
                    $query->orWhere($column, 'LIKE', $searchQuery);
                }
            }
        }

        if ($request->has('columnFilters')) {
            $filters = get_object_vars(json_decode($request->columnFilters));

            foreach ($filters as $key => $value) {
                if (! empty($value)) {
                    $query->orWhere($key, 'like', '%'.$value.'%');
                }
            }
        }

        if ($request->has('sort.0')) {
            $sort = json_decode($request->sort[0]);
            $query->orderBy($sort->field, $sort->type);
        }

        if ($request->has('perPage')) {
            $rows = $query->paginate($request->perPage);
        }

        return $rows;
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
            // 'converted_date' => 'required',
            'person_id' => 'required',
            // 'title' => 'required',
            // 'type' => 'required',
            // 'attr' => 'required',
            'date' => 'required',
            'plac' => 'required',
            // 'addr_id' => 'required',
            'phon' => 'required',
            // 'caus' => 'required',
            // 'age' => 'required',
            // 'agnc' => 'required',
            // 'adop' => 'required',
            // 'places_id' => 'required',
            // 'description' => 'required',
            // 'adop_famc' => 'required',
            // 'year' => 'required',
            // 'month' => 'required',
            // 'day' => 'required'
        ]);

        return PersonEvent::create([
            'converted_date' => $request->converted_date,
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
            'adop' => $request->adop,
            'places_id' => $request->places_id,
            'description' => $request->description,
            'adop_famc' => $request->adop_famc,
            'year' => $request->year,
            'month' => $request->month,
            'day' => $request->day,
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
            // 'converted_date' => 'required',
            'person_id' => 'required',
            // 'title' => 'required',
            // 'type' => 'required',
            // 'attr' => 'required',
            'date' => 'required',
            'plac' => 'required',
            // 'addr_id' => 'required',
            'phon' => 'required',
            // 'caus' => 'required',
            // 'age' => 'required',
            // 'agnc' => 'required',
            // 'adop' => 'required',
            // 'places_id' => 'required',
            // 'description' => 'required',
            // 'adop_famc' => 'required',
            // 'year' => 'required',
            // 'month' => 'required',
            // 'day' => 'required'
        ]);

        $personevent = PersonEvent::find($id);
        $personevent->converted_date = $request->converted_date;
        $personevent->person_id = $request->person_id;
        $personevent->title = $request->title;
        $personevent->type = $request->type;
        $personevent->attr = $request->attr;
        $personevent->date = $request->date;
        $personevent->plac = $request->plac;
        $personevent->addr_id = $request->addr_id;
        $personevent->phon = $request->phon;
        $personevent->caus = $request->caus;
        $personevent->age = $request->age;
        $personevent->agnc = $request->agnc;
        $personevent->adop = $request->adop;
        $personevent->places_id = $request->places_id;
        $personevent->description = $request->description;
        $personevent->adop_famc = $request->adop_famc;
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
        if ($personevent) {
            $personevent->delete();

            return 'true';
        }

        return 'false';
    }
}
