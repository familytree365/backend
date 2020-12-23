<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use App\Models\Tree;
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
        $user = auth()->user();
        $company = DB::connection($this->getConnectionName())->table('user_company')->where('user_id', $user->id)->select('company_id')->first();
        $tree = Tree::where('company_id', $company->company_id)->first();
        $tenant = Tenant::where('tree_id', $tree->id)->first();
        $tenant->makeCurrent();
        return $next($request);
    }
}