<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class RoleController extends ApiController
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
        $roles = tap(Role::latest(), function ($query) use ($request) {
            if ($request->has('keyword')) {
                $query->where('name', 'like', "%{$request->keyword}%")
                        ->orWhere('display_name', 'like', "%{$request->keyword}%");
            } else {
                foreach (['name', 'display_name'] as $field) {
                    $query->where($field, 'like', "%{$request->$field}%");
                }
            }
        })->paginate($request->get('per_page', 20));

        return $this->response->collection($roles);
    }

    /**
     * Get the list of permissions.
     *
     * @return \Illuminate\Http\Response
     */
    public function permissions()
    {
        return $this->response->collection(Permission::all());
    }

    /**
     * Update the role's permissions.
     *
     * @param  Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePermission(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->permissions()->sync($request->get('permissions', []));

        return $this->response->item($role);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->response->item(Role::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response->item(Role::findOrFail($id));
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
        $role = Role::findOrFail($id);

        $role->update($request->all());

        return $this->response->item($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);

        return $this->response->withNoContent();
    }
}
