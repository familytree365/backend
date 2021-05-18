<?php

namespace App\Http\Controllers;

use App\Models\MediaObjectFile;
use Illuminate\Http\Request;

class MediaObjectFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = MediaObjectFile::query();

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
            'gid' => 'required',
            'group' => 'required',
            'form' => 'required',
            'medi' => 'required',
            'type' => 'required',
        ]);

        return MediaObjectFile::create([
            'gid' => $request->gid,
            'group' => $request->group,
            'form' => $request->form,
            'medi' => $request->medi,
            'type' => $request->type,
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
        return MediaObjectFile::find($id);
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
            'gid' => 'required',
            'group' => 'required',
            'form' => 'required',
            'medi' => 'required',
            'type' => 'required',
        ]);

        $mediaobjectfile = MediaObjectFile::find($id);
        $mediaobjectfile->gid = $request->gid;
        $mediaobjectfile->group = $request->group;
        $mediaobjectfile->form = $request->form;
        $mediaobjectfile->medi = $request->medi;
        $mediaobjectfile->type = $request->type;
        $mediaobjectfile->save();

        return $mediaobjectfile;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mediaobjectfile = MediaObjectFile::find($id);
        if ($mediaobjectfile) {
            $mediaobjectfile->delete();

            return 'true';
        }

        return 'false';
    }
}
