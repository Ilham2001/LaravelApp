<?php

namespace App\Http\Controllers;

use App\Project;
use App\Category;
use App\Article;
use App\Wiki;
use App\User;
use App\Http\DTO\ProjectDTO;
use App\Http\DTO\UserDTO;

use Illuminate\Http\Request;
//use Illuminate\Http\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        //dd($projects[1]->members);
        
        $projectsDTO = [];
 
        foreach ($projects as $project) {
            
            $projectDTO = new ProjectDTO;
           
            $projectDTO->id = $project->id;
            $projectDTO->name = $project->name;
            $projectDTO->description = $project->description;
            $projectDTO->website = $project->website;
            $projectDTO->isPublic = $project->isPublic;
            $projectDTO->landing_page = $project->landing_page;
            $projectDTO->isClosed = $project->isClosed;

            $membersDTO = [];

            foreach ($project->members as $member) {
                $memberDTO = new UserDTO;
                $memberDTO->id = $member->id;
                $memberDTO->first_name = $member->first_name;
                $memberDTO->last_name = $member->last_name;
                $memberDTO->email = $member->email;
                $memberDTO->password = $member->password;
                $memberDTO->landing_page = $member->landing_page;
                $memberDTO->role = $member->role->name;
                array_push($membersDTO,$memberDTO);
            }
            $projectDTO->members = $membersDTO;

            array_push($projectsDTO, $projectDTO);
        }

        //dd($projectsDTO);
       json_encode($projectsDTO);

        return $projectsDTO;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($project=Project::create($request->all())) {
            return response()->json([
                'success' => 'Projet créée'
            ],201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $project = Project::find($id);
        
        $categories = $project->categories;
        
        $articles = array();
        
        foreach($categories as $category) {
            array_push($articles, $category->articles);
        }
        
        $wikis = $project->wikis;
        
        $projectDTO = new ProjectDTO;

        $projectDTO->id = $project->id;
        $projectDTO->name = $project->name;
        $projectDTO->description = $project->description;
        $projectDTO->website = $project->website;
        $projectDTO->isPublic = $project->isPublic;
        $projectDTO->landing_page = $project->landing_page;
        $projectDTO->isClosed = $project->isClosed;
        $projectDTO->parent_id = $project->parent_id;
        
        $membersDTO = [];

            foreach ($project->members as $member) {
                $memberDTO = new UserDTO;
                $memberDTO->id = $member->id;
                $memberDTO->first_name = $member->first_name;
                $memberDTO->last_name = $member->last_name;
                $memberDTO->email = $member->email;
                $memberDTO->password = $member->password;
                $memberDTO->landing_page = $member->landing_page;
                $memberDTO->role = $member->role->name;
                array_push($membersDTO,$memberDTO);
            }
            $projectDTO->members = $membersDTO;


        $projectDTO->wikis = $project->wikis;
        $projectDTO->categories = $project->categories;
        $projectDTO->articles = $articles;

        //dd($projectDTO);
        return json_encode($projectDTO);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        if($project->update($request->all())) {
            return response()->json([
                'success' => 'Modification effectuée'
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if($project->delete()) {
            return response()->json([
                'success' => 'Suppression effectuée'
            ],200);
        }
    }

    public function deleteMember($project_id, $member_id)
    {
        $project = Project::find($project_id);
        //dd($project);
        $project->members()->detach($member_id);
        return response()->json([
            'success' => 'Membre supprimé'
        ],200);
    }

    public function addMember($project_id, $member_id)
    {
        $project = Project::find($project_id);
        $project->members()->attach($member_id);
        return response()->json([
            'success' => 'Membre ajouté'
        ],200);
    }
}
