<?php

namespace App\Http\Controllers;

use App\Role;
use App\Http\DTO\RoleDTO;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        $rolesDTO = [];

        foreach($roles as $role) {
           
            $roleDTO = new RoleDTO;

            $roleDTO->id = $role->id;
            $roleDTO->name = $role->name;
            
            $permissions = [];
            foreach($role->permissions as $permission) {
                array_push($permissions, $permission->name);
            }

            $roleDTO->permissions = $permissions;

            array_push($rolesDTO, $roleDTO);
        }

        //dd($rolesDTO);

        return json_encode($rolesDTO);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permissionsIDS = $request->permissions;

        if($role = Role::create([
            'name' => $request->name,
        ]))

        foreach ($permissionsIDS as $permission_id) {
            $role->permissions()->attach($permission_id);
        }
        
        return response()->json([
            'success' => 'Rôle crée'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $roleDTO = new RoleDTO;

        $roleDTO->id = $role->id;
        $roleDTO->name = $role->name;
        $permissions = [];
        foreach($role->permissions as $permission) {
            array_push($permissions, $permission->name);
        }    

        $roleDTO->permissions = $permissions;
        //dd($roleDTO);
        return json_encode($roleDTO);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if($role->delete()) {
            return response()->json([
                'success' => 'Rôle supprimé'
            ],200);
        }
    }
}
