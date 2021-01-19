<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Source;
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
        $query = Source::query();

        if($request->has('searchTerm')) {
            $columnsToSearch = ['name', 'email', 'phone'];
            $search_term = json_decode($request->searchTerm)->searchTerm;
            if(!empty($search_term)) {
                $searchQuery = '%' . $search_term . '%';
                foreach($columnsToSearch as $column) {
                    $query->orWhere($column, 'LIKE', $searchQuery);
                }
            }
        }

        if($request->has('columnFilters')) {

            $filters = get_object_vars(json_decode($request->columnFilters));

            foreach($filters as $key => $value) {
                if(!empty($value)) {
                    $query->orWhere($key, 'like', '%' . $value . '%');
                }
            }
        }

        if($request->has('sort.0')) {
            $sort = json_decode($request->sort[0]);
            $query->orderBy($sort->field, $sort->type);
        }

        if($request->has("perPage")) {
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
            'titl' => 'required',
            'auth' => 'required',
            'data' => 'required',
            'text' => 'required',
            'publ' => 'required',
            'abbr' => 'required',
            'name' => 'required',
            'description' => 'required',
            'repository_id' => 'required',
            'author_id' => 'required',
            'publication_id' => 'required',
            'is_active' => 'required',
            'group' => 'required',
            'gid' => 'required',
            'quay' => 'required',
            'page' => 'required'
        ]);

        return Source::create([
            'sour' => $request->name,
            'titl' => $request->name,
            'auth' => $request->name,
            'data' => $request->name,
            'text' => $request->name,
            'publ' => $request->name,
            'abbr' => $request->name,
            'name' => $request->name,
            'description' => $request->name,
            'repository_id' => $request->name,
            'author_id' => $request->name,
            'publication_id' => $request->name,
            'is_active' => $request->name,
            'group' => $request->name,
            'gid' => $request->name,
            'quay' => $request->name,
            'page' => $request->name
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
            'titl' => 'required',
            'auth' => 'required',
            'data' => 'required',
            'text' => 'required',
            'publ' => 'required',
            'abbr' => 'required',
            'name' => 'required',
            'description' => 'required',
            'repository_id' => 'required',
            'author_id' => 'required',
            'publication_id' => 'required',
            'is_active' => 'required',
            'group' => 'required',
            'gid' => 'required',
            'quay' => 'required',
            'page' => 'required'
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
        $source->is_active = $request->is_active;
        $source->group = $request->group;
        $source->gid = $request->gid;
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
        if($source) {
            $source->delete();
            return "true";
        }
        return "false";
    }

    public function get()
    {
        $type_data = DB::table('types')->get();
        return $type_data;
    }
}
