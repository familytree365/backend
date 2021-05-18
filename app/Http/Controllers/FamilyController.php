<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Person;
use DB;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Family::query()->with(['husband', 'wife']);

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['description', 'is_active', 'husband_id', 'wife_id', 'type_id', 'chan', 'nchi', 'rin'];
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
        if (! count($request->all())) {
            $rows = $query->get();
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
        $male = Person::where('sex', 'M')->get();
        $female = Person::where('sex', 'F')->get();
        $types = DB::table('types')->get();

        return response()->json(['male' => $male, 'female' => $female, 'types' => $types]);
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
            'description' => 'required',
            'is_active' => 'required',
            'husband_id' => 'required',
            'wife_id' => 'required',
            'type_id' => 'required',
            'chan' => 'required',
            'nchi' => 'required',
            'rin' => 'required',
        ]);

        return Family::create([
            'description' => $request->description,
            'is_active' => $request->is_active,
            'husband_id' => $request->husband_id,
            'wife_id' => $request->wife_id,
            'type_id' => $request->type_id,
            'chan' => $request->chan,
            'nchi' => $request->nchi,
            'rin' => $request->rin,
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
        return Family::find($id);
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
            'description' => 'required',
            'is_active' => 'required',
            'husband_id' => 'required',
            'wife_id' => 'required',
            'type_id' => 'required',
            'chan' => 'required',
            'nchi' => 'required',
            'rin' => 'required',
        ]);

        $family = Family::find($id);
        $family->description = $request->description;
        $family->is_active = $request->is_active;
        $family->husband_id = $request->husband_id;
        $family->wife_id = $request->wife_id;
        $family->type_id = $request->type_id;
        $family->chan = $request->chan;
        $family->nchi = $request->nchi;
        $family->rin = $request->rin;
        $family->save();

        return $family;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $family = Family::find($id);
        if ($family) {
            $family->delete();

            return 'true';
        }

        return 'false';
    }
}
