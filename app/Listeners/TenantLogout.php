<?php

namespace App\Listeners;

use App\Models\Tree;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Tenant;

class TenantLogout
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
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = auth()->user();
        if($user) {
            $company = DB::connection($this->getConnectionName())
                ->table('user_company')
                ->where('user_id', $user->id)
                ->select('company_id')
                ->first();
            if($company) {
                $tree = Tree::where('company_id', $company->company_id)->first();
                $tenant = Tenant::where('tree_id', $tree->id)->first();
                session()->flush();
                $tenant->forgetCurrent();
            }

        }
    }
}
