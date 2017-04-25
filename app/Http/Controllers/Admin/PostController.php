<?php

namespace App\Http\Controllers\Admin;

use App\Post;
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

                if ($request->has('id')) $query->where('id', $request->id);
            }
        })->paginate($request->get('per_page', 20));

        return $this->response->collection($posts);
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
