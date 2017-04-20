<?php

namespace App\Http\Controllers\Admin;

use App\UserLog;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserLogController extends ApiController
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
        $actions = tap(UserLog::latest(), function ($query) use ($request) {
            if ($request->has('keyword')) {
                $query->where('action', 'like', "%{$request->keyword}%")
                        ->orWhere('action_type', 'like', "%{$request->keyword}%");
            } else {
                foreach (['action', 'action_type'] as $field) {
                    $query->where($field, 'like', "%{$request->$field}%");
                }
            }
        })->paginate($request->get('per_page', 20));

        return $this->response->collection($actions);
    }
}
