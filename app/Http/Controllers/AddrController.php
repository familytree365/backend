<?php

namespace App\Http\Controllers;

use App\Models\Addr;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Addr $addr
     * @return LengthAwarePaginator|array
     */
    public function index(Request $request, Addr $addr)
    {
        $rows = [];
        $query = $addr->query();

        if ($searchTerm = $request->searchTerm) {
            $columnsToSearch = collect($addr->getFillable());

            $columnsToSearch->each(
                function ($column) use ($query, $searchTerm) {
                    $query->orWhere($column, 'like', "%$searchTerm%");
                }
            );
        }

        if ($request->has('columnFilters')) {
            $filters = get_object_vars(json_decode($request->columnFilters));

            foreach ($filters as $key => $value) {
                if (!empty($value)) {
                    $query->orWhere($key, 'like', '%' . $value . '%');
                }
            }
        }

        if ($request->has('sort.0')) {
            $sort = json_decode($request->sort[0]);
            $query->orderBy($sort->field, $sort->type);
        }

        if ($request->has('perPage')) {
            $rows = $query->paginate($request->perPage);
        }

        return $rows;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Addr::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Addr
     */
    public function store(Request $request): Addr
    {
        $request->validate(
            [
                'city' => 'required',
                'stae' => 'required',
            ]
        );

        return Addr::create(
            [
                'adr1' => $request->adr1,
                'adr2' => $request->adr2,
                'city' => $request->city,
                'stae' => $request->stae,
                'post' => $request->post,
                'ctry' => $request->ctry,
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id): Response
    {
        return Addr::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Addr
     */
    public function update(Request $request, int $id): Addr
    {
        $request->validate(
            [
                'city' => 'required',
                'stae' => 'required',
            ]
        );

        $addr = Addr::find($id);
        $addr->adr1 = $request->adr1;
        $addr->adr2 = $request->adr2;
        $addr->city = $request->city;
        $addr->stae = $request->stae;
        $addr->post = $request->post;
        $addr->ctry = $request->ctry;
        $addr->save();

        return $addr;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string
     */
    public function destroy($id): string
    {
        $addr = Addr::find($id);

        if ($addr) {
            $addr->delete();

            return 'true';
        }

        return 'false';
    }

    /**
     * @return Addr[]|Collection
     */
    public function get()
    {
        return Addr::all();
    }
}
