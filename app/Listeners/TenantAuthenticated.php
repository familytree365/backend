<?php

namespace App\Listeners;

use App\Models\Company;
use App\Models\Tree;
use App\Models\User;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Tenant;

class TenantAuthenticated
{
    use UsesLandlordConnection;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Authenticated  $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        $user = auth()->user();
        $company = DB::connection($this->getConnectionName())
                        ->table('user_company')
                        ->where('user_id', $user->id)
                        ->select('company_id')
                        ->first();
        if($company) {
            $tree = Tree::where('company_id', $company->company_id)->first();
            $tenant = Tenant::where('tree_id', $tree->id)->first();
            $tenant->makeCurrent();
        }
    }
}
