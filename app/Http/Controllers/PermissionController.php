<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\Http\DTO\PermissionDTO;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();


        //$roles =$permissions[0]->roles;
        
        //dd($roles[0]->id);

        $permissionsDTO= [];

        foreach ($permissions as $permission) {
            $permissionDTO = new PermissionDTO;
            $permissionDTO->id = $permission->id;
            $permissionDTO->name = $permission->name;
            array_push($permissionsDTO,$permissionDTO);
        }
        //dd($permissionsDTO);
        return $permissionsDTO;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
