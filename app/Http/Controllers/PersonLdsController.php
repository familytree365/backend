<?php

namespace App\Http\Controllers;

use App\Models\PersonLds;
use Illuminate\Http\Request;
use voku\helper\ASCII;

class PersonLdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = PersonLds::query();

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['group', 'type', 'stat', 'date', 'plac', 'temp', 'slac_famc'];
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
            'group' => 'required',
        ]);

        return PersonLds::create([
            'group' => $request->group,
            'type' => $request->type,
            'stat' => $request->stat,
            'date' => $request->date,
            'plac' => $request->plac,
            'temp' => $request->temp,
            'slac_famc' => $request->slac_famc,
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
        return PersonLds::find($id);
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
        ]);

        $personlds = PersonLds::find($id);
        $personlds->group = $request->group;
        $personlds->type = $request->type;
        $personlds->date = $request->date;
        $personlds->plac = $request->plac;
        $personlds->temp = $request->temp;
        $personlds->slac_famc = $request->slac_famc;
        $personlds->save();

        return $personlds;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personlds = PersonLds::find($id);
        if ($personlds) {
            $personlds->delete();

            return 'true';
        }

        return 'false';
    }
}
