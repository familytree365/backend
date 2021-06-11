<?php

namespace App\Http\Controllers;

use App\Jobs\DnaMatching;
use App\Models\Dna;
use Auth;
use Illuminate\Http\Request;

class DnaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Dna $dna)
    {
        $query = $dna->query();

        if ($searchTerm = $request->searchTerm) {
            $columnsToSearch = collect($dna->getFillable());

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
        if ($request->hasFile('file')) {
            if ($request->file('file')->isValid()) {
                try {
                    $currentUser = Auth::user();
                    $file_name = 'dna_'.$request->file('file')->getClientOriginalName().uniqid().'.'.$request->file('file')->extension();
                    $request->file->storeAs('dna', $file_name);
                    define('STDIN', fopen('php://stdin', 'r'));
                    $random_string = unique_random('dnas', 'variable_name', 5);
                    $var_name = 'var_'.$random_string;
                    $filename = 'app/dna/'.$file_name;
                    $user_id = $currentUser->id;
                    $dna = new Dna();
                    $dna->name = 'DNA Kit for user '.$user_id;
                    $dna->user_id = $user_id;
                    $dna->variable_name = $var_name;
                    $dna->file_name = $file_name;
                    $dna->save();
                    DnaMatching::dispatch($currentUser, $var_name, $file_name);

                    return [
                        'message' => __('The dna was successfully created'),
                        'redirect' => 'dna.edit',
                        'param' => ['dna' => $dna->id],
                    ];
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            }

            return ['File corrupted'];
        }

        return response()->json(['Not uploaded'], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Dna::find($id);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $dna = Dna::find($id);
        if ($user->id == $dna->user_id) {
            $dna->delete();

            return [
                'message' => __('The dna was successfully deleted'),
                'redirect' => 'dna.index',
            ];
        } else {
            return [
                'message' => __('The dna could not be deleted'),
                'redirect' => 'dna.index',
            ];
        }
    }
}
