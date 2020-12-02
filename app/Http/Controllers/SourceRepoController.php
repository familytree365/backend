<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SourceRepo;

class SourceRepoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables()->of(SourceRepo::query())->toJson();
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
            'repo_id' => 'required',
            'caln' => 'required'

        ]);

        return SourceRepo::create([
            'group' => $request->group,
            'gid' => $request->gid,
            'repo_id' => $request->repo_id,
            'caln' => $request->caln
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
        return SourceRepo::find($id);
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
            'repo_id' => 'required',
            'caln' => 'required'
        ]);

        $sourcerepo = SourceRepo::find($id);
        $sourcerepo->group = $request->group;
        $sourcerepo->gid = $request->gid;
        $sourcerepo->repo_id = $request->repo_id;
        $sourcerepo->caln = $request->caln;
        $sourcerepo->save();
        return $sourcerepo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sourcerepo = SourceRepo::find($id);
        if($sourcerepo) {
            $sourcerepo->delete();
            return "true";
        }
        return "false";
    }
}
