<?php

namespace App\Jobs;

use App\Models\Geneanum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Spatie\Multitenancy\Jobs\NotTenantAware;

class SyncWithGeneanum implements ShouldQueue, NotTenantAware
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const URL = 'http://static.geneanum.com/libs/grid/malte_bapteme.php?annee_limite=75&_search=false&nd=%s&rows=100&page=%s&sidx=Nom_Baptise&sord=asc';
    private const MAX_RETRY = 3;

    private $current_page;
    private $retry;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $page = 1, int $retry = 0)
    {
        $this->current_page = $page;
        $this->retry        = $retry;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = sprintf(self::URL, time() - mt_rand(1, 30), $this->current_page);

        $response = Http::get($url);

        if ($response->failed()) {
            if (++$this->retry > self::MAX_RETRY) {
                return;
            }

            dispatch(new SyncWithGeneanum($this->current_page, $this->retry));
        }

        $result = $response->json();

        $has_more_result = $result['total'] > $result['page'];
        if ($has_more_result) {
            dispatch(new SyncWithGeneanum(++$this->current_page))
                ->delay(now()->addSeconds(mt_rand(10, 60)));
        }

        $rows = $result['rows'];

        foreach ($rows as $row) {
            $remote_id = $row['id'];
            [
                $date,
                $name,
                $first_name,
                $sex,
                $father_first_name,
                $father_is_dead,
                $mother_name,
                $mother_first_name,
                $mother_is_dead,
                $observation1,
                $observation2,
                $observation3,
                $observation4,
                $officer,
                $parish,
                $source,
                $update,
            ] = $row['cell'];

            Geneanum::updateOrCreate(['remote_id' => $remote_id],
                [
                    'date'              => $date,
                    'name'              => $name,
                    'first_name'        => $first_name,
                    'sex'               => $sex,
                    'father_first_name' => $father_first_name,
                    'father_is_dead'    => $father_is_dead,
                    'mother_name'       => $mother_name,
                    'mother_first_name' => $mother_first_name,
                    'mother_is_dead'    => $mother_is_dead,
                    'observation1'      => $observation1,
                    'observation2'      => $observation2,
                    'observation3'      => $observation3,
                    'observation4'      => $observation4,
                    'officer'           => $officer,
                    'parish'            => $parish,
                    'source'            => $source,
                    'update'            => $update,
                ]);
        }

    }
}
