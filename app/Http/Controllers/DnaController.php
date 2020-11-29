<?php

namespace App\Http\Controllers;

use App\Jobs\DnaMatching;
use Illuminate\Http\Request;
use App\Models\Dna;

class DnaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(Dna::query())->toJson();
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
    public function store(Request $request, Dna $dna)
    {
        $slug = $request->get('slug');
        if ($request->hasFile('file')) {
            if ($request->file('file')->isValid()) {
                try {
//                    $conn = $this->getConnection();
//                    $db = $this->getDB();
                    $currentUser = Auth::user();
                    $file_name = 'dna_' . $request->file('file')->getClientOriginalName() . uniqid() . '.' . $request->file('file')->extension();
//                    $file_name = 'dna_' . $request->file('file')->getClientOriginalName() . uniqid() . '.csv';
                    $request->file->storeAs('dna', $file_name);
                    define('STDIN', fopen('php://stdin', 'r'));
                    $random_string = unique_random('dnas', 'variable_name', 5);
                    $var_name = 'var_' . $random_string;
                    $filename = 'app/dna/' . $file_name;
                    $user_id = $currentUser->id;
                    $dna->name = 'DNA Kit for user ' . $user_id;
                    $dna->user_id = $user_id;
                    $dna->variable_name = $var_name;
                    $dna->file_name = $file_name;
                    $dna->save();
                    DnaMatching::dispatch($var_name, $file_name);
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
        return ['Not uploaded'];
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
        $dna = Dna::find($id);
        if($dna) {
            $dna->delete();
            return "true";
        }
        return "false";
    }
}
