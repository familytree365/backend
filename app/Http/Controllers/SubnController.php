<?php

namespace App\Http\Controllers;

use App\Models\Subn;
use Illuminate\Http\Request;

class SubnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Subn::query();

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['subm', 'famf', 'temp', 'ance', 'desc', 'rin'];
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
            'desc' => 'required',
        ]);

        return Subn::create([
            'subm' => $request->subm,
            'famf' => $request->famf,
            'temp' => $request->temp,
            'ance' => $request->ance,
            'desc' => $request->desc,
            'ordi' => $request->ordi,
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
        return Subn::find($id);
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
            'desc' => 'required',

        ]);

        $subn = Subn::find($id);
        $subn->subm = $request->subm;
        $subn->famf = $request->famf;
        $subn->temp = $request->temp;
        $subn->ance = $request->ance;
        $subn->desc = $request->desc;
        $subn->ordi = $request->ordi;
        $subn->rin = $request->rin;
        $subn->save();

        return $subn;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subn = Subn::find($id);
        if ($subn) {
            $subn->delete();

            return 'true';
        }

        return 'false';
    }
}
