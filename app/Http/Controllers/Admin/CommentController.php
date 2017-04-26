<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CommentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comments = tap(Comment::latest(), function ($query) use ($request) {
            if ($request->has('keyword')) {
                $query->where('commentable_type', 'like', "%{$request->keyword}%");
            } else {
                foreach (['commentable_type'] as $field) {
                    if ($request->has($field)) {
                        $query->where($field, 'like', "%{$request->$field}%");
                    }
                }

                if ($request->has('id')) {
                    $query->where('id', $request->id);
                }
            }
        })->paginate($request->get('per_page', 20));

        return $this->response->collection($comments);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::destroy($id);

        return $this->response->withNoContent();
    }
}
