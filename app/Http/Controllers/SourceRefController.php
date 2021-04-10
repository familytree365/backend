<?php

namespace App\Http\Controllers;

use App\Models\SourceRef;
use Illuminate\Http\Request;

class SourceRefController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = SourceRef::query();

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['name', 'email', 'phone'];
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
            'sour_id' => 'required',
            'text' => 'required',
            'quay' => 'required',
            'page' => 'required',
        ]);

        return SourceRef::create([
            'group' => $request->group,
            'sour_id' => $request->sour_id,
            'text' => $request->text,
            'quay' => $request->quay,
            'page' => $request->page,
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
        return SourceRef::find($id);
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
            'sour_id' => 'required',
            'text' => 'required',
            'quay' => 'required',
            'page' => 'required',
        ]);

        $sourceref = SourceRef::find($id);
        $sourceref->group = $request->group;
        $sourceref->sour_id = $request->sour_id;
        $sourceref->text = $request->text;
        $sourceref->quay = $request->quay;
        $sourceref->page = $request->page;
        $sourceref->save();

        return $sourceref;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sourceref = SourceRef::find($id);
        if ($sourceref) {
            $sourceref->delete();

            return 'true';
        }

        return 'false';
    }
}
