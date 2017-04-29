<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PostController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = tap(Post::latest(), function ($query) use ($request) {
            if ($request->keyword) {
                $query->where('title', 'like', "%{$request->keyword}%")
                        ->orWhere('slug', 'like', "%{$request->keyword}%");
            } else {
                foreach (['title', 'slug'] as $field) {
                    if ($request->has($field)) {
                        $query->where($field, 'like', "%{$request->$field}%");
                    }
                }

                if ($request->has('id')) {
                    $query->where('id', $request->id);
                }
            }
        })->paginate($request->get('per_page', 20));

        return $this->response->collection($posts);
    }

    public function recommend($id)
    {
        $post = Post::findOrFail($id);

        $post->update(['recommended_at' => Carbon::now()]);

        return $this->response->item($post);
    }

    public function off($id)
    {
        $post = Post::findOrFail($id);

        $post->update(['recommended_at' => null]);

        return $this->response->item($post);
    }

    public function ban(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->update([
            'banned_at' => Carbon::now(),
            'banned_reason' => $request->reason
        ]);

        return $this->response->item($post);
    }

    public function lift($id)
    {
        $post = Post::findOrFail($id);

        $post->update([
            'banned_at' => null,
            'banned_reason' => null
        ]);

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
        Post::destroy($id);

        return $this->response->withNoContent();
    }
}
