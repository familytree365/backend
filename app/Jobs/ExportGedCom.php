<?php

namespace App\Jobs;

use Auth;
use File;
use FamilyTree365\LaravelGedcom\Utils\GedcomGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportGedCom implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $family_id;
    protected $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request, $file)
    {
        //
        $this->family_id = 0;
        $this->file = $file;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $p_id = 0;
        $f_id = $this->family_id;
        $up_nest = 3;
        $down_nest = 3;
        $writer = new GedcomGenerator($p_id, $f_id, $up_nest, $down_nest);
        $content = $writer->getGedcomPerson();
        // $user_id = Auth::user()->id;
        $destinationPath = public_path().'/upload/';
        if (! is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        File::put($destinationPath .'/' . $this->file, $content);

        return 0;
    }
}
