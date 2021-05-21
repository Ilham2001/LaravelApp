<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
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
        }

        if($document->save()) {
            return response()->json([
                'success' => 'File uploaded successfully'
            ],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}
