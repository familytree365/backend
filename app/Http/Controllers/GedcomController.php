<?php

namespace App\Http\Controllers;

use App\Jobs\ImportGedcom;
use App\Models\ImportJob;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class GedcomController extends Controller
{
    use UsesLandlordConnection;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = '';
        if ($request->hasFile('file')) {
            if ($request->file('file')->isValid()) {
                try {
                    $conn = 'tenant';
                    $currentTenant = app('currentTenant');
                    $db = $currentTenant->database;
                    $currentUser = auth()->user();
                    $_name = uniqid().'.ged';
                    $request->file->storeAs('gedcom', $_name);
                    define('STDIN', fopen('php://stdin', 'r'));
                    // $parser = new GedcomParser();
                    // $parser->parse($request->file('file'), $slug, true);
                    $filename = 'app/gedcom/'.$_name;
                    ImportGedcom::dispatch($filename, $slug, $currentUser->id, $conn, $db);

                    return ['File uploaded: conn:-'.$conn.'-'];
                } catch (\Exception $e) {
                    return ['Not uploaded'];
                }
            }

            return ['File corrupted'];
        }

        return ['Not uploaded'];
    }

    /**
     * Display the specified progress.
     */
    public function progress()
    {
        $user_id = Auth::user()->id;
        $runningjob = ImportJob::orderby('id', 'DESC')->first();
        $slug = null;
        if ($runningjob != null) {
            $slug = $runningjob->slug;
        }
        $ret = [];
        $ret['slug'] = $slug;
        $ret['user'] = $user_id;

        return $ret;
    }
}
