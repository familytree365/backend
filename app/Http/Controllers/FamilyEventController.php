<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Family;
use App\Models\FamilyEvent;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamilyEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = FamilyEvent::query()->with(['family', 'place']);

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['family_id', 'places_id', 'date', 'title', 'description', 'year', 'month', 'day', 'type', 'plac', 'phon', 'caus', 'age', 'agnc', 'husb', 'wife', 'converted_date', 'addr_id'];
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

    public function get()
    {
        $company = Company::all()->count();

        return $company;
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
            'family_id' => 'required',
            'places_id' => 'required',
            'date' => 'required',
            'title' => 'required',
            'description' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
            'type' => 'required',
            'plac' => 'required',
            'phon' => 'required',
            'caus' => 'required',
            'age' => 'required',
            // 'agnc' => 'required',
            'husb' => 'required',
            'wife' => 'required',
            // 'converted_date' => 'required',
            // 'addr_id' => 'required'

        ]);

        return FamilyEvent::create([
            'family_id' => $request->family_id,
            'places_id' => $request->places_id,
            'date' => $request->date,
            'title' => $request->title,
            'description' => $request->description,
            'year' => $request->year,
            'month' => $request->month,
            'day' => $request->day,
            'type' => $request->type,
            'plac' => $request->plac,
            'phon' => $request->phon,
            'caus' => $request->caus,
            'age' => $request->age,
            // 'agnc' => $request->agnc,
            'husb' => $request->husb,
            'wife' => $request->wife,
            // 'converted_date' => $request->converted_date,
            // 'addr_id' => $request->addr_id
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
        return FamilyEvent::find($id);
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
            'family_id' => 'required',
            'places_id' => 'required',
            'date' => 'required',
            'title' => 'required',
            'description' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
            'type' => 'required',
            'plac' => 'required',
            'phon' => 'required',
            'caus' => 'required',
            'age' => 'required',
            // 'agnc' => 'required',
            'husb' => 'required',
            'wife' => 'required',
            // 'converted_date' => 'required',
            // 'addr_id' => 'required'

        ]);

        $familyevent = FamilyEvent::find($id);
        $familyevent->family_id = $request->family_id;
        $familyevent->places_id = $request->places_id;
        $familyevent->date = $request->date;
        $familyevent->title = $request->title;
        $familyevent->description = $request->description;
        $familyevent->year = $request->year;
        $familyevent->month = $request->month;
        $familyevent->day = $request->day;
        $familyevent->type = $request->type;
        $familyevent->plac = $request->plac;
        $familyevent->phon = $request->phon;
        $familyevent->caus = $request->caus;
        $familyevent->age = $request->age;
        $familyevent->agnc = $request->agnc;
        $familyevent->husb = $request->husb;
        $familyevent->wife = $request->wife;
        $familyevent->converted_date = $request->converted_date;
        $familyevent->addr_id = $request->addr_id;
        $familyevent->save();

        return $familyevent;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $familyevent = FamilyEvent::find($id);
        if ($familyevent) {
            $familyevent->delete();

            return 'true';
        }

        return 'false';
    }
}
