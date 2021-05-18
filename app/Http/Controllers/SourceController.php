<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Source::query()->with(['publication', 'repositories', 'author', 'type']);

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['titl', 'sour', 'auth', 'data', 'text', 'publ', 'abbr', 'name', 'description', 'repository_id', 'author_id', 'publication_id', 'type_id', 'is_active', 'group', 'quay', 'page'];
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
            $relationship_column = ['repositories.name', 'author.name', 'publication.name', 'type.name'];
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
            'sour' => 'required',
            'auth' => 'required',
            'name' => 'required',
            'repository_id' => 'required',
            'author_id' => 'required',
            'publication_id' => 'required',
            'type_id' => 'required',
            'is_active' => 'required',

        ]);

        return Source::create([
            'sour' => $request->sour,
            'titl' => $request->titl,
            'auth' => $request->auth,
            'data' => $request->data,
            'text' => $request->text,
            'publ' => $request->publ,
            'abbr' => $request->abbr,
            'name' => $request->name,
            'description' => $request->description,
            'repository_id' => $request->repository_id,
            'author_id' => $request->author_id,
            'publication_id' => $request->publication_id,
            'type_id' => $request->type_id,
            'is_active' => $request->is_active,
            'group' => $request->group,
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
        return Source::find($id);
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
            'sour' => 'required',
            'auth' => 'required',
            'name' => 'required',
            'repository_id' => 'required',
            'author_id' => 'required',
            'publication_id' => 'required',
            'type_id' => 'required',
            'is_active' => 'required',

        ]);

        $source = Source::find($id);
        $source->sour = $request->sour;
        $source->titl = $request->titl;
        $source->auth = $request->auth;
        $source->data = $request->data;
        $source->text = $request->text;
        $source->publ = $request->publ;
        $source->abbr = $request->abbr;
        $source->name = $request->name;
        $source->description = $request->description;
        $source->repository_id = $request->repository_id;
        $source->author_id = $request->author_id;
        $source->publication_id = $request->publication_id;
        $source->type_id = $request->type_id;
        $source->is_active = $request->is_active;
        $source->group = $request->group;
        $source->quay = $request->quay;
        $source->page = $request->page;
        $source->save();

        return $source;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $source = Source::find($id);
        if ($source) {
            $source->delete();

            return 'true';
        }

        return 'false';
    }

    public function get()
    {
        $type_data = DB::table('types')->get();

        return $type_data;
    }
}
