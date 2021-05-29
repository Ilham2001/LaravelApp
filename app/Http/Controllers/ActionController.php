<?php

namespace App\Http\Controllers;

use App\Action;
use App\Http\DTO\ActionDTO;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actions = Action::all()->sortByDesc('created_at');
        
        $actionsDTO = [];

        foreach ($actions as $action) {
            $actionDTO= new ActionDTO;

            $actionDTO->id = $action->id;
            $actionDTO->type = $action->type_action->code;
            $actionDTO->user = $action->user->first_name . ' ' . $action->user->last_name;
            
            if ($action->project) {
                $actionDTO->project = $action->project->name;
            }
            
            if ($action->article) {
                $actionDTO->article = $action->article->title;
            }

            if ($action->wiki) {
                $actionDTO->wiki = $action->wiki->title;
            }
            $actionDTO->created_at = $action->created_at;
            $actionDTO->updated_at = $action->updated_at;

            array_push($actionsDTO, $actionDTO);
        }

        //dd($actionsDTO);

        return json_encode($actionsDTO);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function show(Action $action)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Action $action)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function destroy(Action $action)
    {
        //
    }
}
