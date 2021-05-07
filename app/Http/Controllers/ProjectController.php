<?php

namespace App\Http\Controllers;

use App\Project;
use App\Category;
use App\Article;
use App\Wiki;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    public function show($id) {

        $project = Project::find($id);
        
        $categories = $project->categories;

        $articles = array();

        foreach($categories as $category) {
            array_push($articles, $category->articles);
        }
        
        $wikis = $project->wikis;

        return $project->toJson(JSON_PRETTY_PRINT);
        //return response()->json(['project'=>$project,'categories'=>$categories, 'articles'=>$articles]);
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
