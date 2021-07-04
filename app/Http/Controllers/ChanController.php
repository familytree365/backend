<?php

namespace App\Http\Controllers;

use App\Models\Chan;
use Illuminate\Http\Request;

class ChanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Chan $chan)
    {
        $query = $chan->query();

        if ($searchTerm = $request->searchTerm) {
            $columnsToSearch = collect($chan->getFillable());

            $columnsToSearch->each(function ($column) use ($query, $searchTerm) {
                $query->orWhere($column, 'like', "%$searchTerm%");
            });
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
        ]);

        return Chan::create([
            'group' => $request->group,
            'date' => $request->date,
            'time' => $request->time,
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
        return Chan::find($id);
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
        ]);

        $chan = Chan::find($id);
        $chan->group = $request->group;
        $chan->date = $request->date;
        $chan->time = $request->time;
        $chan->save();

        return $chan;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chan = Chan::find($id);
        if ($chan) {
            $chan->delete();

            return 'true';
        }

        return 'false';
    }
}
