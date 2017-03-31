<?php

namespace App\Http\Controllers\Admin;

use App\Series;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SeriesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $series = tap(Series::latest(), function ($query) use ($request) {
            if ($request->has('keyword')) {
                $query->where('title', 'like', "%{$request->keyword}%");
            } else {
                foreach (['title'] as $field) {
                    if ($request->has($field)) {
                        $query->where($field, 'like', "%{$request->$field}%");
                    }
                }
            }
        })->paginate($request->get('per_page', 20));

        return $this->response->collection($series);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->response->item(Series::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response->item(Series::findOrFail($id));
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
        $series = Series::findOrFail($id);

        $series->update($request->all());

        return $this->response->item($series);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Series::destroy($id);

        return $this->response->withNoContent();
    }
}
