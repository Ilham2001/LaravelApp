<?php

namespace App\Http\Controllers;

use App\Project;
use App\Category;
use App\Article;
use App\Wiki;
use App\User;
use App\Http\DTO\UserDTO;
use App\Http\DTO\WikiDTO;
use App\Http\DTO\ProjectDTO;
use App\Http\DTO\ArticleDTO;
use App\Http\DTO\SearchResultDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function search($data)
    {
        $searchResult = new SearchResultDTO;

        $projects = Project::where('name', 'like', '%'. $data .'%')
            ->orWhere('description', 'like', '%'. $data .'%')
            ->orWhere('website', 'like', '%'. $data .'%')
            ->orWhere('landing_page', 'like', '%'. $data .'%')
            ->get();
            
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
            $projectDTO->created_at = $project->created_at;
            $projectDTO->updated_at = $project->updated_at;
    
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


        $articles = Article::where('title', 'like', '%'. $data .'%')
            ->orWhere('summary', 'like', '%'. $data .'%')
            ->orWhere('environment', 'like', '%'. $data .'%')
            ->orWhere('description', 'like', '%'. $data .'%')
            ->orWhere('error_message', 'like', '%'. $data .'%')
            ->orWhere('ticket_number', 'like', '%'. $data .'%')
            ->orWhere('cause', 'like', '%'. $data .'%')
            ->orWhere('resolution', 'like', '%'. $data .'%')
            ->orWhere('keywords', 'like', '%'. $data .'%')
            ->orWhere('workaround', 'like', '%'. $data .'%')
            ->get();

        $articlesDTO = [];

        foreach($articles as $article) {
            
            $articleDTO = new ArticleDTO;
        
            $articleDTO->id = $article->id;
            $articleDTO->title = $article->title;
            $articleDTO->summary = $article->summary;
            $articleDTO->environment = $article->environment;
            $articleDTO->description = $article->description;
            $articleDTO->error_message = $article->error_message;
            $articleDTO->ticket_number = $article->ticket_number;
            $articleDTO->cause = $article->cause;
            $articleDTO->resolution = $article->resolution;
            $articleDTO->keywords = $article->keywords;
            $articleDTO->workaround = $article->workaround;
            $articleDTO->category_id = $article->category_id;
            $author = User::find($article->user_id);
            $articleDTO->author = $author->first_name . " " . $author->last_name;
            $articleDTO->documents = $article->documents;
            $articleDTO->created_at = $article->created_at;
            $articleDTO->updated_at = $article->updated_at;

            array_push($articlesDTO, $articleDTO);
        }

        $wikis = Wiki::where('title', 'like', '%'. $data .'%')
            ->orWhere('content', 'like', '%'. $data .'%')
            ->get();
        
        $wikisDTO = [];
        
        foreach ($wikis as $wiki) {
            $wikiDTO = new WikiDTO;
            $wikiDTO->id = $wiki->id;
            $wikiDTO->title = $wiki->title;
            $wikiDTO->content = $wiki->content;
            $wikiDTO->project_id = $wiki->project_id;
            $wikiDTO->created_at = $wiki->created_at;
            $wikiDTO->updated_at = $wiki->updated_at;
            array_push($wikisDTO, $wikiDTO);

        }
        
        $length = count($articlesDTO) + count($projectsDTO) + count($wikisDTO);
        $projects_length = count($projectsDTO);
        $articles_length = count($articlesDTO);
        $wikis_length = count($wikisDTO);

        $searchResult->projects = $projectsDTO;
        $searchResult->articles = $articlesDTO;
        $searchResult->wikis = $wikisDTO;
        $searchResult->result_length = $length;
        $searchResult->projects_length = $projects_length;
        $searchResult->articles_length = $articles_length;
        $searchResult->wikis_length = $wikis_length;

        return json_encode($searchResult);
    }
}
