<?php

namespace App\Http\Controllers;

use App\Models\ForumPostComment;
use Illuminate\Http\Request;

class ForumPostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ForumPostComment::query();

        if ($request->has('searchTerm')) {
            $columnsToSearch = ['name', 'email', 'phone'];
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
            'post_id' => 'required|integer',
            'content' => 'required',
            'author' => 'required',
        ]);

        return ForumTopic::create([
            'post_id' => $request->topic_id,
            'content' => $request->content,
            'author' => $request->author,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ForumPostComment  $forumPostComment
     * @return \Illuminate\Http\Response
     */
    public function show(ForumPostComment $forumPostComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ForumPostComment  $forumPostComment
     * @return \Illuminate\Http\Response
     */
    public function edit(ForumPostComment $forumPostComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ForumPostComment  $forumPostComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ForumPostComment $forumPostComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ForumPostComment  $forumPostComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ForumPostComment $forumPostComment)
    {
        //
    }
}
