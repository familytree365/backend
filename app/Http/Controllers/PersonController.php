<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Person::query();

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['title', 'name', 'appellative', 'uid', 'email', 'phone', 'birthday', 'deathday', 'bank', 'bank_account', 'obs', 'givn', 'surn', 'type', 'npfx', 'nick', 'spfx', 'nsfx', 'secx', 'description', 'child_in_family_id', 'chan', 'rin', 'resn', 'rfn', 'afn'];
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
            $rows = $query->get()->toArray();
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

        $person = new Person();
        $person->title = $request->title;
        $person->name = $request->name;
        $person->appellative = $request->appellative;
        $person->uid = $request->uid;
        $person->email = $request->email;
        $person->phone = $request->phone;
        $person->birthday = $request->birthday;
        $person->deathday = $request->deathday;
        $person->bank = $request->bank;
        $person->bank_account = $request->bank_account;
        $person->obs = $request->obs;
        $person->givn = $request->givn;
        $person->surn = $request->surn;
        $person->type = $request->type;
        $person->npfx = $request->npfx;
        $person->nick = $request->nick;
        $person->spfx = $request->spfx;
        $person->nsfx = $request->nsfx;
        $person->sex = $request->sex;
        $person->description = $request->description;
        $person->child_in_family_id = $request->child_in_family_id;
        $person->chan = $request->chan;
        $person->rin = $request->rin;
        $person->resn = $request->resn;
        $person->rfn = $request->rfn;
        $person->afn = $request->afn;
        $person->save();

        return $person;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Person::find($id);
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

        $person = Person::find($id);
        $person->title = $request->title;
        $person->name = $request->name;
        $person->appellative = $request->appellative;
        $person->uid = $request->uid;
        $person->email = $request->email;
        $person->phone = $request->phone;
        $person->birthday = $request->birthday;
        $person->deathday = $request->deathday;
        $person->bank = $request->bank;
        $person->bank_account = $request->bank_account;
        $person->obs = $request->obs;
        $person->givn = $request->givn;
        $person->surn = $request->surn;
        $person->type = $request->type;
        $person->npfx = $request->npfx;
        $person->nick = $request->nick;
        $person->spfx = $request->spfx;
        $person->nsfx = $request->nsfx;
        $person->sex = $request->sex;
        $person->description = $request->description;
        $person->child_in_family_id = $request->child_in_family_id;
        $person->chan = $request->chan;
        $person->rin = $request->rin;
        $person->resn = $request->resn;
        $person->rfn = $request->rfn;
        $person->afn = $request->afn;
        $person->save();

        return $person;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = Person::find($id);
        if ($person) {
            $person->delete();

            return 'true';
        }

        return 'false';
    }
}
