<?php

namespace App\Http\Controllers;

use App\Models\PersonName;
use Illuminate\Http\Request;

class PersonNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = PersonName::query();

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
            'gid' => 'required',
            'type' => 'required',
            'name' => 'required',
            'npfx' => 'required',
            'givn' => 'required',
            'nick' => 'required',
            'spfx' => 'required',
            'surn' => 'required',
            'nsfx' => 'required',
        ]);

        return PersonName::create([
            'group' => $request->group,
            'gid' => $request->gid,
            'type' => $request->type,
            'name' => $request->name,
            'npfx' => $request->npfx,
            'givn' => $request->givn,
            'nick' => $request->nick,
            'spfx' => $request->spfx,
            'surn' => $request->surn,
            'nsfx' => $request->nsfx,
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
        return PersonName::find($id);
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
            'gid' => 'required',
            'type' => 'required',
            'name' => 'required',
            'npfx' => 'required',
            'givn' => 'required',
            'nick' => 'required',
            'spfx' => 'required',
            'surn' => 'required',
            'nsfx' => 'required',
        ]);

        $personname = PersonName::find($id);
        $personname->group = $request->group;
        $personname->gid = $request->gid;
        $personname->type = $request->type;
        $personname->name = $request->name;
        $personname->npfx = $request->npfx;
        $personname->givn = $request->givn;
        $personname->nick = $request->nick;
        $personname->spfx = $request->spfx;
        $personname->surn = $request->surn;
        $personname->nsfx = $request->nsfx;
        $personname->save();

        return $personname;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personname = PersonName::find($id);
        if ($personname) {
            $personname->delete();

            return 'true';
        }

        return 'false';
    }
}
