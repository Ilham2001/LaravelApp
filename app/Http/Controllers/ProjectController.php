<?php

namespace App\Http\Controllers;

use App\Project;
use App\Category;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$project = new Project;

        //$parent = Project::find(8);

        $project->name = ":)";
        $project->description = "descriptionnnnn";
        $project->parent_id =2;

        $project->save();
        dd($project);*/


        $projects = Project::all();
        return $projects->toJson(JSON_PRETTY_PRINT);
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
                'success' => 'Projet crée'
            ],201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return $project->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
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

    public function test()
    {
        # code...
    }
}
