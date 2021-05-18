<?php

namespace App\Http\Controllers;

use App\Models\Addr;
use App\Models\Subm;
use Illuminate\Http\Request;

class SubmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Subm::query()->with('addr');

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['group', 'name', 'addr_id', 'rin', 'rfn', 'lang', 'email', 'phon', 'fax', 'www'];
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
            $relationship_column = ['addr.adr2'];
            foreach ($filters as $key => $value) {
                if (! in_array($key, $relationship_column)) {
                    if (! empty($value)) {
                        $query->orWhere($key, 'like', '%'.$value.'%');
                    }
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
            'name' => 'required',
        ]);

        return Subm::create([
            'group' => $request->group,
            'name' => $request->name,
            'addr_id' => $request->addr_id,
            'rin' => $request->rin,
            'rfn' => $request->rfn,
            'lang' => $request->lang,
            'phon' => $request->phon,
            'email' => $request->email,
            'fax' => $request->fax,
            'www' => $request->www,
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
        return Subm::find($id);
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
            'name' => 'required',
        ]);

        $subm = Subm::find($id);
        $subm->group = $request->group;
        $subm->name = $request->name;
        $subm->addr_id = $request->addr_id;
        $subm->rin = $request->rin;
        $subm->rfn = $request->rfn;
        $subm->lang = $request->lang;
        $subm->phon = $request->phon;
        $subm->email = $request->email;
        $subm->fax = $request->fax;
        $subm->www = $request->www;
        $subm->save();

        return $subm;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subm = Subm::find($id);
        if ($subm) {
            $subm->delete();

            return 'true';
        }

        return 'false';
    }
}
