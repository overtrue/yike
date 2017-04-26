<?php

namespace App\Http\Controllers\Admin;

use App\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ReportController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reports = Report::latest()->paginate($request->get('per_page', 20));

        return $this->response->collection($reports);
    }
}
