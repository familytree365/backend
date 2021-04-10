<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Repository::query()->with(['type', 'addr']);

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['repo', 'name', 'addr_id', 'rin', 'email', 'phon', 'fax', 'www', 'description', 'type_id', 'is_active'];
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
            $relationship_column = ['addr.adr1', 'type.name'];
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
            'repo' => 'required',
            'addr_id' => 'required',
            'phon' => 'required',
            'email' => 'required',
            'name' => 'required',
            'type_id' => 'required',
            'is_active' => 'required',
        ]);

        return Repository::create([
            'repo' => $request->repo,
            'addr_id' => $request->addr_id,
            'rin' => $request->rin,
            'phon' => $request->phon,
            'email' => $request->email,
            'fax' => $request->fax,
            'www' => $request->www,
            'name' => $request->name,
            'is_active' => $request->is_active,
            'description' => $request->description,
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
        return Repository::find($id);
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
            'repo' => 'required',
            'addr_id' => 'required',
            'phon' => 'required',
            'email' => 'required',
            'name' => 'required',
            'type_id' => 'required',
            'is_active' => 'required',
        ]);

        $repository = Repository::find($id);
        $repository->repo = $request->repo;
        $repository->addr_id = $request->addr_id;
        $repository->rin = $request->rin;
        $repository->phon = $request->phon;
        $repository->email = $request->email;
        $repository->fax = $request->fax;
        $repository->www = $request->www;
        $repository->name = $request->name;
        $repository->is_active = $request->is_active;
        $repository->description = $request->description;
        $repository->save();

        return $repository;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $repository = Repository::find($id);
        if ($repository) {
            $repository->delete();

            return 'true';
        }

        return 'false';
    }

    public function get()
    {
        $repo_data = Repository::all();

        return $repo_data;
    }
}
