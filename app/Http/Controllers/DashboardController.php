<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Family;
use App\Models\Person;
use App\Models\Tree;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $male = Person::where('sex', 'M')->get()->count();
        $female = Person::where('sex', 'F')->get()->count();
        $unknown = Person::whereNull('sex')->get()->count();
        $familiesjoined = Family::all()->count();
        $peoplesattached = Person::all()->count();
        $chart = [$male, $female, $unknown];

        return ['chart' => $chart, 'familiesjoined' => $familiesjoined, 'peoplesattached' => $peoplesattached];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $company = $user->Company();
        $trees = Tree::where('company_id', $company->id)->get();

        return $trees;
    }

    public function getCompany()
    {
        $user = auth()->user();
        $company = $user->Company;

        return $company;
    }

    public function getTree()
    {
        $trees = Tree::where('company_id', request('company_id'))->get();

        return $trees;
    }

    public function changedb(Request $request)
    {
        $company_id = $request->get('company_id');
        $tree_id = $request->get('tree_id');
        if (! empty($company_id) && ! empty($tree_id)) {
            $user = auth()->user();
            $companies_id = $user->Company()->pluck('companies.id');
            $company = $user->Company()->update([
                'current_tenant'=> 0,
            ]);
            $company = Company::find($company_id);
            $company->current_tenant = 1;
            $company->save();
            Tree::whereIn('company_id', $companies_id)->update(['current_tenant' => 0]);
            $tree = Tree::find($tree_id);
            $tree->current_tenant = 1;
            $tree->save();

            return response()->json(['changedb' => true]);
        } else {
            return response()->json(['changedb' => false]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
    }

    public function trial()
    {
        $user = auth()->user();
        if ($user->subscribed('default')) {
            $days = Carbon::now()->diffInDays(Carbon::parse($user->subscription('default')->asStripeSubscription()->current_period_end));
        } else {
            $days = Carbon::now()->diffInDays($user->trial_ends_at);
        }

        return ['days' => $days];
    }
}
