<?php

namespace App\Http\Controllers;

use App\Article;
use App\Document;
use App\User;
use File;
use App\Http\DTO\ArticleDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();
        return $articles->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = new Article;
        if($article = Article::create([
            'title' => $request->title,
            'summary' => $request->summary,
            'environment' => $request->environment,
            'description' => $request->description,
            'error_message' => $request->error_message,
            'ticket_number' => $request->ticket_number,
            'cause' => $request->cause,
            'resolution' => $request->resolution,
            'keywords' => $request->keywords,
            'workaround' => $request->workaround,
            'environment' => $request->environment,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
        ]))

        $category = Category::find($request->category_id);
        $category->projects()->attach($request->project_id);
        /* Create the document */
        $document = new Document;
        if($request->hasFile('reference')) {
            /* Original file name with extension */
            $originalFileName = $request->file('reference')->getClientOriginalName();
            
            /* File name without extension */
            $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);
            
            /* Extension */
            $extension = $request->file('reference')->getClientOriginalExtension();

            /* Complete file name = original name + without spaces + rand numbers + extension */
            $completeFile = str_replace(' ','_',$fileName).'-'.rand().'_'.time().'.'.$extension; 
            
            $path = $request->file('reference')->storeAs('public/documents',$completeFile);
            //dd($path);

            $document->title = $fileName;
            $document->reference = $completeFile;
            $document->article()->associate($article);
            $document->save();
        }

        return response()->json([
            'success' => 'Article créée'
            ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        //dd($article->documents[0]);

        
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

        return json_encode($articleDTO);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $article = Article::find($id);
        if($article->update($request->all())) {
            return response()->json([
                'success' => 'Modification effectuée'
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        if($article->delete()) {
            $article->documents()->delete();
            return response()->json([
                'success' => 'Suppression effectuée'
            ],200);
        }
    }
}
