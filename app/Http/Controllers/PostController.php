<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Events\ViewPost;
use App\Http\Requests\CreatePostRequest;
use Illuminate\Http\Request;

class PostController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = tap(Post::with('user'), function($query) use ($request) {
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);

                if (auth()->id() != $request->user_id) {
                    $query->noDraft();
                }
            }
            if ($request->has('sort_by')) {
                $query->{$request->sort_by}();
            }
        })->paginate(15);

        return $this->response->collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreatePostRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        return $this->response->item(Post::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::whereId($id)->orWhere('slug', $id)->firstOrFail();

        event(new ViewPost($post));

        return $this->response->item($post);
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
        $post = Post::findOrFail($id);
        $post->update($request->all());

        return $this->response->item($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
