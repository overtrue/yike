<?php

namespace App\Http\Controllers\Admin;

use App\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class FeedbackController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $feedbacks = tap(Feedback::latest(), function ($query) use ($request) {
            if ($request->keyword) {
                $query->where('ip', 'like', "%{$request->keyword}%");
            } else {
                foreach (['ip'] as $field) {
                    if ($request->has($field)) {
                        $query->where($field, 'like', "%{$request->$field}%");
                    }
                }
            }
        })->paginate($request->get('per_page', 20));

        return $this->response->collection($feedbacks);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Feedback::destroy($id);

        return $this->response->withNoContent();
    }
}
