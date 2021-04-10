<?php

namespace App\Http\Controllers;

use App\Models\MediaObject;
use App\Models\MediaObjectFile;
use Illuminate\Http\Request;

class MediaObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = MediaObject::query();

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['group', 'titl', 'obje_id', 'rin'];
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
            'titl' => 'required',
        ]);

        return MediaObject::create([
            'group' => $request->group,
            'titl' => $request->titl,
            'obje_id' => $request->obje_id,
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
        return MediaObject::find($id);
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
            'titl' => 'required',
        ]);

        $mediaobject = MediaObject::find($id);
        $mediaobject->group = $request->group;
        $mediaobject->titl = $request->titl;
        $mediaobject->obje_id = $request->obje_id;
        $mediaobject->rin = $request->rin;
        $mediaobject->save();

        return $mediaobject;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mediaobject = MediaObject::find($id);
        if ($mediaobject) {
            $mediaobject->delete();

            return 'true';
        }

        return 'false';
    }
}
