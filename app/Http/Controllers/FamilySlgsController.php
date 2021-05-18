<?php

namespace App\Http\Controllers;

use App\Models\FamilySlgs;
use Illuminate\Http\Request;

class FamilySlgsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = FamilySlgs::query()->with('family');

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['family_id', 'stat', 'date', 'plac', 'temp'];
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
            'family_id' => 'required',
            'stat' => 'required',
            'date' => 'required',
            'plac' => 'required',
            'temp' => 'required',
        ]);

        return FamilySlgs::create([
            'family_id' => $request->family_id,
            'stat' => $request->stat,
            'date' => $request->date,
            'plac' => $request->plac,
            'temp' => $request->temp,
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
        return FamilySlgs::find($id);
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
            'stat' => 'required',
            'date' => 'required',
            'plac' => 'required',
            'temp' => 'required',
        ]);

        $familyslgs = FamilySlgs::find($id);
        $familyslgs->family_id = $request->family_id;
        $familyslgs->stat = $request->stat;
        $familyslgs->date = $request->date;
        $familyslgs->plac = $request->plac;
        $familyslgs->temp = $request->temp;
        $familyslgs->save();

        return $familyslgs;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $familyslgs = FamilySlgs::find($id);
        if ($familyslgs) {
            $familyslgs->delete();

            return 'true';
        }

        return 'false';
    }
}
