<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Family;
use App\Models\Person;
use App\Models\Tree;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class TreeController extends Controller
{
    use UsesLandlordConnection;

    private $persons;
    private $unions;
    private $links;
    private $nest;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Tree::query()->with('company');

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['name'];
            $search_term = json_decode($request->searchTerm)->searchTerm;
            if (! empty($search_term)) {
                $searchQuery = '%'.$search_term.'%';
                foreach ($columnsToSearch as $column) {
                    $query->orWhere($column, 'LIKE', $searchQuery);
                }
            }
        }

        if ($request->has('columnFilters')) {
            $filters = get_object_vars(json_decode($request->columnFilters));

            foreach ($filters as $key => $value) {
                if (! empty($value)) {
                    $query->orWhere($key, 'like', '%'.$value.'%');
                }
            }
        }

        $user = auth()->user();
        $company = $user->Company()->pluck('companies.id');
        $query->whereIn('company_id', $company);

        if ($request->has('sort.0')) {
            $sort = json_decode($request->sort[0]);
            $query->orderBy($sort->field, $sort->type);
        }

        if ($request->has('perPage')) {
            $rows = $query->paginate($request->perPage);
        }
        if (! count($request->all())) {
            $rows = $query->get()->toArray();
        }

        return $rows;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $companies_id = $user->Company()->pluck('companies.id');
        $roles = $user->roles;
        $role = $roles[0]->id;
        if ($role == 7 || $role == 8) {
            if (Tree::whereIn('company_id', $companies_id)->count() < 1) {
                return response()->json(['create_tree' => true]);
            } else {
                return response()->json(['create_tree' => false]);
            }
        } elseif ($role == 5 || $role == 6) {
            if (Tree::whereIn('company_id', $companies_id)->count() < 10) {
                return response()->json(['create_tree' => true]);
            } else {
                return response()->json(['create_tree' => false]);
            }
        } elseif ($role == 3 || $role == 4) {
            return response()->json(['create_tree' => true]);
        } else {
            return response()->json(['create_tree' => false]);
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
        $request->validate([
            'name' => 'required',
            'company_id' => 'required',
        ]);
        $tree_id = Tree::create([
            'name' => $request->name,
            'company_id' => $request->company_id,
            'current_tenant' => 0,
            'description' => $request->description,
        ])->id;

        $tenant_id = DB::connection($this->getConnectionName())->table('tenants')->insertGetId([
            'name' => 'tenant'.$tree_id,
            'tree_id' => $tree_id,
            'database' => 'tenant'.$tree_id,
        ]);

        DB::statement('create database tenant'.$tree_id);

        Artisan::call('tenants:artisan "migrate --database=tenant --force"');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $start_id = $request->get('start_id', 3);
        $nest = $request->get('nest', 3);
        $ret = [];
        $ret['start'] = (int) $start_id;
        $this->persons = [];
        $this->unions = [];
        $this->links = [];
        $this->nest = $nest;
        // $this->getGraphData((int)$start_id);
        $this->getGraphDataUpward((int) $start_id);
        $ret['persons'] = $this->persons;
        $ret['unions'] = $this->unions;
        $ret['links'] = $this->links;
        // ExportGedCom::dispatch(2, $request);
        // $file = 'file.GED';
        // $destinationPath = public_path().'/upload/';
        // $ret['link'] = $destinationPath.$file;

        return $ret;
    }

    private function getGraphData($start_id, $nest = 1)
    {
        $conn = $this->getConnection();
        $db = $this->getDB();

        if ($this->nest >= $nest) {
            $nest++;

            // add family
            $families = Family::on($conn)->where('husband_id', $start_id)->orwhere('wife_id', $start_id)->get();
            $own_unions = [];

            // add children
            foreach ($families as $family) {
                $family_id = $family->id;
                $father = Person::on($conn)->find($family->husband_id);
                $mother = Person::on($conn)->find($family->wife_id);
                // add partner to person
                // add partner link

                if (isset($father->id)) {
                    $_families = Family::on($conn)->where('husband_id', $father->id)->orwhere('wife_id', $father->id)->select('id')->get();
                    $_union_ids = [];
                    foreach ($_families as $item) {
                        $_union_ids[] = 'u'.$item->id;
                    }
                    $father->setAttribute('own_unions', $_union_ids);
                    $this->persons[$father->id] = $father;
                    $this->links[] = [$father->id, 'u'.$family_id];
                }
                if (isset($mother->id)) {
                    $_families = Family::on($conn)->where('husband_id', $mother->id)->orwhere('wife_id', $mother->id)->select('id')->get();
                    $_union_ids = [];
                    foreach ($_families as $item) {
                        $_union_ids[] = $item->id;
                    }
                    $mother->setAttribute('own_unions', $_union_ids);
                    $this->persons[$mother->id] = $mother;
                    $this->links[] = [$mother->id, 'u'.$family_id];
                }

                // find children
                $children = Person::on($conn)->where('child_in_family_id', $family_id)->get();
                $children_ids = [];
                foreach ($children as $child) {
                    $child_id = $child->id;
                    // add child to person
                    // parent_union
                    $child_data = Person::on($conn)->find($child_id);
                    $_families = Family::on($conn)->where('husband_id', $child_id)->orwhere('wife_id', $child_id)->select('id')->get();
                    $_union_ids = [];
                    foreach ($_families as $item) {
                        $_union_ids[] = $item->id;
                    }
                    $child_data->setAttribute('own_unions', $_union_ids);
                    $this->persons[$child_id] = $child_data;

                    // add union-child link
                    $this->links[] = ['u'.$family_id, $child_id];

                    // make union child filds
                    $children_ids[] = $child_id;
                    $this->getGraphData($child_id, $nest);
                }

                // compose union item and add to unions
                $union = [];
                $union['id'] = 'u'.$family_id;
                $union['partner'] = [isset($father->id) ? $father->id : null, isset($mother->id) ? $mother->id : null];
                $union['children'] = $children_ids;
                $this->unions['u'.$family_id] = $union;
            }
        }

        return true;
    }

    private function getGraphDataUpward($start_id, $nest = 0)
    {
        $conn = $this->getConnection();
        $db = $this->getDB();

        $threshold = (int) ($this->nest) * 1;
        $has = (int) ($nest) * 1;
        if ($threshold >= $has) {
            $person = Person::on($conn)->find($start_id);
            // do not process for null
            if ($person == null) {
                return;
            }

            // do not process again
            if (array_key_exists($start_id, $this->persons)) {
                return;
            }
            // do self
            if (! array_key_exists($start_id, $this->persons)) {
                // this is not added
                $_families = Family::on($conn)->where('husband_id', $start_id)->orwhere('wife_id', $start_id)->select('id')->get();
                $_union_ids = [];
                foreach ($_families as $item) {
                    $_union_ids[] = 'u'.$item->id;
                    // add current family link
                    // $this->links[] = [$start_id, 'u'.$item->id];
                    array_unshift($this->links, [$start_id, 'u'.$item->id]);
                }
                $person->setAttribute('own_unions', $_union_ids);
                $person->setAttribute('parent_union', 'u'.$person->child_in_family_id);
                // add to persons
                $this->persons[$start_id] = $person;

                // get self's parents data
                $p_family_id = $person->child_in_family_id;
                if (! empty($p_family_id)) {
                    // add parent family link
                    // $this->links[] = ['u'.$p_family_id,  $start_id] ;
                    array_unshift($this->links, ['u'.$p_family_id,  $start_id]);
                    $p_family = Family::on($conn)->find($p_family_id);
                    if (isset($p_family->husband_id)) {
                        $p_fatherid = $p_family->husband_id;
                        $this->getGraphDataUpward($p_fatherid, $nest + 1);
                    }
                    if (isset($p_family->wife_id)) {
                        $p_motherid = $p_family->wife_id;
                        $this->getGraphDataUpward($p_motherid, $nest + 1);
                    }
                }
            }
            // get partner
            $cu_families = Family::on($conn)->where('husband_id', $start_id)->orwhere('wife_id', $start_id)->get();
            foreach ($cu_families as $family) {
                $family_id = $family->id;
                $father = Person::on($conn)->find($family->husband_id);
                $mother = Person::on($conn)->find($family->wife_id);
                if (isset($father->id)) {
                    if (! array_key_exists($father->id, $this->persons)) {
                        // this is not added
                        $_families = Family::on($conn)->where('husband_id', $father->id)->orwhere('wife_id', $father->id)->select('id')->get();
                        $_union_ids = [];
                        foreach ($_families as $item) {
                            $_union_ids[] = 'u'.$item->id;
                        }
                        $father->setAttribute('own_unions', $_union_ids);
                        $father->setAttribute('parent_union', 'u'.$father->child_in_family_id);
                        // add to persons
                        $this->persons[$father->id] = $father;

                        // add current family link
                        // $this->links[] = [$father->id, 'u'.$family_id];
                        array_unshift($this->links, [$father->id, 'u'.$family_id]);
                        // get husband's parents data
                        $p_family_id = $father->child_in_family_id;
                        if (! empty($p_family_id)) {
                            // add parent family link
                            // $this->links[] = ['u'.$p_family_id,  $father->id] ;
                            array_unshift($this->links, ['u'.$p_family_id,  $father->id]);
                            $p_family = Family::on($conn)->find($p_family_id);
                            if (isset($p_family->husband_id)) {
                                $p_fatherid = $p_family->husband_id;
                                $this->getGraphDataUpward($p_fatherid, $nest + 1);
                            }
                            if (isset($p_family->wife_id)) {
                                $p_motherid = $p_family->wife_id;
                                $this->getGraphDataUpward($p_motherid, $nest + 1);
                            }
                        }
                    }
                }
                if (isset($mother->id)) {
                    if (! array_key_exists($mother->id, $this->persons)) {
                        // this is not added
                        $_families = Family::on($conn)->where('husband_id', $mother->id)->orwhere('wife_id', $mother->id)->select('id')->get();
                        $_union_ids = [];
                        foreach ($_families as $item) {
                            $_union_ids[] = $item->id;
                        }
                        $mother->setAttribute('own_unions', $_union_ids);
                        $mother->setAttribute('parent_union', 'u'.$mother->child_in_family_id);
                        // add to person
                        $this->persons[$mother->id] = $mother;
                        // add current family link
                        // $this->links[] = [$mother->id, 'u'.$family_id];
                        array_unshift($this->links, [$mother->id, 'u'.$family_id]);
                        // get wifee's parents data
                        $p_family_id = $mother->child_in_family_id;
                        if (! empty($p_family_id)) {
                            // add parent family link
                            // $this->links[] = ['u'.$p_family_id,  $father->id] ;
                            array_unshift($this->links, ['u'.$p_family_id,  $mother->id]);

                            $p_family = Family::on($conn)->find($p_family_id);
                            if (isset($p_family->husband_id)) {
                                $p_fatherid = $p_family->husband_id;
                                $this->getGraphDataUpward($p_fatherid, $nest + 1);
                            }
                            if (isset($p_family->wife_id)) {
                                $p_motherid = $p_family->wife_id;
                                $this->getGraphDataUpward($p_motherid, $nest + 1);
                            }
                        }
                    }
                }

                // find children
                $children = Person::on($conn)->where('child_in_family_id', $family_id)->get();
                $children_ids = [];
                foreach ($children as $child) {
                    $child_id = $child->id;
                    $children_ids[] = $child_id;
                }

                // compose union item and add to unions
                $union = [];
                $union['id'] = 'u'.$family_id;
                $union['partner'] = [isset($father->id) ? $father->id : null, isset($mother->id) ? $mother->id : null];
                $union['children'] = $children_ids;
                $this->unions['u'.$family_id] = $union;
            }
            // get brother/sisters
            $brothers = Person::on($conn)->where('child_in_family_id', $person->child_in_family_id)
                ->whereNotNull('child_in_family_id')
                ->where('id', '<>', $start_id)->get();
            // $nest = $nest -1;
            foreach ($brothers as $brother) {
                $this->getGraphDataUpward($brother->id, $nest);
            }
        } else {
            return;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tree = Tree::find($id);

        return $tree;
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
            'name' => 'required',
            'description' => 'required',
        ]);

        $tree = Tree::find($id);
        $tree->name = $request->name;
        $tree->description = $request->description;
        $tree->save();

        return $tree;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tree = Tree::find($id);
        if ($tree) {
            $tree->delete();

            return 'true';
        }

        return 'false';
    }
}
