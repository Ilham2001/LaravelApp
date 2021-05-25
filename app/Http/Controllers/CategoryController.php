<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use App\Http\DTO\ArticleDTO;
use App\Http\DTO\CategoryDTO;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return $categories->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Category::create($request->all())) {
            return response()->json([
                'success' => 'Catégorie créée'
            ],200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        $categoryDTO = new CategoryDTO;
        
        $articlesDTO = [];
        
        foreach ($category->articles as $article) {
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
            $articleDTO->created_at = $article->created_at;
            $articleDTO->updated_at = $article->updated_at;
            array_push($articlesDTO, $articleDTO);
        }

        $categoryDTO->id = $category->id;
        $categoryDTO->title = $category->title;
        $categoryDTO->description = $category->description;
        $categoryDTO->description = $category->description;
        $categoryDTO->projects = $category->projects;
        $categoryDTO->articles = $articlesDTO;
        $categoryDTO->parent_id = $category->parent_id;
        $categoryDTO->children = $category->children;
        $categoryDTO->articles_length = count($category->children);

        return json_encode($categoryDTO);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if($category->update($request->all())) {
            return response()->json([
                'success' => 'Modification effectuée'
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->delete()) {
            return response()->json([
                'success' => 'Suppression effectuée'
            ],200);
        }
    }

    public function articles_length($id)
    {
        $category = Category::find($id);
        $articles_length = count($category->articles);
        return $articles_length;
    }
}
