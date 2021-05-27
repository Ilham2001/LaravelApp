<?php

namespace App\Http\Controllers;

use App\Wiki;
use App\User;
use App\Action;
use App\Document;
use App\TypeAction;
use App\Http\DTO\WikiDTO;
use Illuminate\Http\Request;

class WikiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $wiki = new Wiki;
        if($wiki = Wiki::create([
            'title' => $request->title,
            'content' => $request->content,
            'project_id' => $request->project_id,
            'user_id' => $request->user_id
        ]))
        

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
            
            $document->wiki()->associate($wiki);

            $document->save();
        }

        /* Create action */
        $action = new Action;
        $user = User::find($request->user_id);
        $type_action = TypeAction::find(4);
        $action->user()->associate($user);
        $action->type_action()->associate($type_action);
        $action->wiki()->associate($wiki);
        $action->save();
        
        
        return response()->json([
            'success' => 'Wiki créée'
            ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wiki  $wiki
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wiki = Wiki::find($id);
        $wikiDTO = new WikiDTO;

        $wikiDTO->id = $wiki->id;
        $wikiDTO->title = $wiki->title;
        $wikiDTO->content = $wiki->content;
        $wikiDTO->project_id = $wiki->project_id;
        $wikiDTO->user_id = $wiki->user_id;
        

        return json_encode($wikiDTO);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wiki  $wiki
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $wiki = Wiki::find($id);
        if($wiki->update([
            'title' => $request->title,
            'content' => $request->content,
            'project_id' => $request->project_id,
            'user_id' => $request->user_id
        ])) 
        {
            /* Create action */
            $action = new Action;
            $user = User::find($request->user_id);
            $type_action = TypeAction::find(5);
            $action->user()->associate($user);
            $action->type_action()->associate($type_action);
            $action->wiki()->associate($wiki);
            $action->save();
            
            return response()->json([
                'success' => 'Modification effectuée'
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wiki  $wiki
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wiki = Wiki::find($id);
        if($wiki->delete()) {
            return response()->json([
                'success' => 'Suppression effectuée'
            ],200);
        }
    }
}
