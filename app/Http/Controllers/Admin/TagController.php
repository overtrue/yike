<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use App\Http\Controllers\ApiController;

class TagController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags = tap(Tag::latest(), function ($query) use ($request) {
            if ($request->has('keyword')) {
                $query->where('name', 'like', "%{$request->keyword}%");
            } else {
                foreach (['name'] as $field) {
                    if ($request->has($field)) {
                        $query->where($field, 'like', "%{$request->$field}%");
                    }
                }
            }
        })->paginate($request->get('per_page', 20));

        return $this->response->collection($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        return $this->response->item(Tag::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response->item(Tag::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $tag->update($request->all());

        return $this->response->item($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::destroy($id);

        return $this->response->withNoContent();
    }
}
