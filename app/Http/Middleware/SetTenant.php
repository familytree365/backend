<?php

namespace App\Http\Middleware;

use App\Models\Tree;
use Closure;
use DB;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Tenant;

class SetTenant
{
    use UsesLandlordConnection;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // $user = auth()->user();
        // $company = DB::connection($this->getConnectionName())->table('user_company')->where('user_id', $user->id)->select('company_id')->first();
        // $tree = Tree::where('company_id', $company->company_id)->first();
        // $tenant = Tenant::where('tree_id', $tree->id)->first();
        // $tenant->makeCurrent();
        if (Tenant::checkCurrent()) {
            Tenant::forgetCurrent();
            $user = auth()->user();
            $company = $user->Company()->where('current_tenant', '=', 1)->first();
            $tree = Tree::where('current_tenant', '=', 1)->where('company_id', $company->id)->first();
            $tenant = Tenant::where('tree_id', $tree->id)->first();
            $tenant->makeCurrent();
        }

        return $next($request);
    }
}
