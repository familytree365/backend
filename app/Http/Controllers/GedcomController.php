<?php

namespace App\Http\Controllers;

use App\Jobs\ExportGedCom;
use App\Jobs\ImportGedcom;
use App\Models\ImportJob;
use GenealogiaWebsite\LaravelGedcom\Utils\GedcomGenerator;
use GenealogiaWebsite\LaravelGedcom\Utils\GedcomParser;
use GenealogiaWebsite\LaravelGedcom\Utils\GedcomWriter;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class GedcomController extends Controller
{
    use UsesLandlordConnection;

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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
                    $_name = uniqid() . '.ged';
                    $request->file->storeAs('gedcom', $_name);
                    define('STDIN', fopen('php://stdin', 'r'));
                    // $parser = new GedcomParser();
                    // $parser->parse($request->file('file'), $slug, true);
                    $filename = 'app/gedcom/' . $_name;
                    ImportGedcom::dispatch($filename, $slug, $currentUser->id, $conn, $db);

                    return ['File uploaded: conn:-' . $conn . '-'];
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

    /**
     * Generate gedcom file
     */
    public function gedcomExport()
    {

        //TODO need data for testing
//        $conn = 'tenant';
//        $p_id = 1;
//        $f_id = 1;
//        $up_nest = 0;
//        $down_nest = 0;
//        $_name = uniqid() . '.ged';

//        $parser = new GedcomWriter();
//        $parser->parse($request->file('file'), $slug, true);
//        $writer = new GedcomGenerator($p_id, $f_id, $up_nest, $down_nest);
//        $content = $parser->parse($_name, '', true);
//        dd($content);
//        $content = $writer->getGedcomPerson();
//        ExportGedCom::dispatch();

//        sleep(5);
        $file = uniqid() . '.GED';
        $path = public_path($file);
        file_put_contents($path, '');

        return response()->json([
            'file' => url($file)
        ]);
    }

    /**
     * Check Gedcom export completion
     * @param Request $request
     */
    public function gedcomDownload(Request $request)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($request->file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($request->file));
        flush(); // Flush system output buffer
       return response()->download($request->file);
    }

    /**
     * Check Gedcom export completion
     */
    public function checkGedcomExport()
    {

    }
}
