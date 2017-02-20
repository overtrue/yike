<?php

namespace App\Http\Controllers\Admin;

use App\Image;
use App\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BannerController extends ApiController
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
        $banners = Banner::paginate($request->get('per_page', 20));

        return $this->response->collection($banners);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $data['enabled_at'] = Carbon::parse($data['enabled_at']);
        $data['expired_at'] = Carbon::parse($data['expired_at']);

        return $this->response->item(Banner::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response->item(Banner::findOrFail($id));
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
        $banner = Banner::findOrFail($id);

        $data = $request->all();

        $data['enabled_at'] = Carbon::parse($data['enabled_at']);
        $data['expired_at'] = Carbon::parse($data['expired_at']);

        $banner->update($data);

        return $this->response->item($banner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Banner::destroy($id);

        return $this->response->withNoContent();
    }
}
