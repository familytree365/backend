<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use Illuminate\Http\Request;

class ForumTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ForumTopic::query();

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['title', 'email', 'phone'];
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

        if ($request->has('sort.0')) {
            $sort = json_decode($request->sort[0]);
            $query->orderBy($sort->field, $sort->type);
        }

        if ($request->has('perPage')) {
            $rows = $query->paginate($request->perPage);
        } else {
            $rows = $query->get();
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
        //
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
            'category_id' => 'required|integer',
            'title' => 'required',
            'content' => 'required',
        ]);

        return ForumTopic::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'content' => $request->content,
            'created_by' => $request->user()->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ForumTopic  $forumTopic
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ForumTopic::where('slug', $id)->with('category')->with('posts')->with('author')->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ForumTopic  $forumTopic
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
     * @param  \App\Models\ForumTopic  $forumTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'title' => 'required',
            'content' => 'required',
        ]);
        $topic = ForumTopic::find($id);
        if ($topic) {
            $topic->category_id = $request->category_id;
            $topic->title = $request->title;
            $topic->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ForumTopic  $forumTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(ForumTopic $forumTopic)
    {
        //
    }
}
