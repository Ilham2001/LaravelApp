<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Http\DTO\UserDTO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTExecptions;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd("here");
        
        $users = User::all();
        $roles = Role::all();

        $usersDTO = [];

       //dd($users);

        foreach ($users as $user) {
            //dd($user);
            $userDTO = new UserDTO;
            $userDTO->id = $user->id;
            $userDTO->first_name = $user->first_name;
            $userDTO->last_name = $user->last_name;
            $userDTO->email = $user->email;
            $userDTO->password = $user->password;
            $userDTO->landing_page = $user->landing_page;
            $role_name = $user->role->name;
            $userDTO->role = $user->role->name;
            array_push($usersDTO, $userDTO);
        }
        //json_encode($usersDTO);
        //dd($usersDTO);
        
        return $usersDTO;
        //->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'landing_page' => $request->landing_page,
            'role_id' => $request->role_id
        ]))
        return response()->json([
            'success' => 'Utilisateur crée'
        ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $userDTO = new UserDTO;
        $userDTO->id = $user->id;
        $userDTO->first_name = $user->first_name;
        $userDTO->last_name = $user->last_name;
        $userDTO->email = $user->email;
        $userDTO->password = $user->password;
        $userDTO->landing_page = $user->landing_page;
        $userDTO->role = $user->role->name;
        $userDTO->role_id = $user->role_id;

        return json_encode($userDTO);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($user->update($request->all())) {
            return response()->json([
                'success' => 'Modification effectuée'
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user->delete()) {
            return response()->json([
                'success' => 'Utilisateur supprimé'
            ],200);
        }
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        try {
            if(!JWTAuth::attempt($credentials)) {
                $response['data'] = null;
                $response['status'] = 0;
                $response['code'] = 401;
                $response['message'] = 'Email ou mot de passe incorrecte';
                return response()->json($response);
            }
        } catch (JWTException $e) {
            $response['data'] = null;
            $response['code'] = 500;
            $response['message'] = 'Impossible de créer Token';
            return response()->json($response);
        }

        $user = auth()->user();
        $data['token'] = auth()->claims([
            'id' => $user->id,
            'email' => $user->email
        ])->attempt($credentials);

        $response['data'] = $data;
        $response['status'] = 1;
        $response['code'] = 200;
        $response['message'] = 'Authentification réussie';
        return response()->json($response);
    }
}
