<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wiki extends Model
{
    public $table = "wikis";
    protected $fillable = [
        'id',
        'title',
        'content',
        'project_id',
        'user_id'
    ];

    /**
     * Wiki belongs to one project
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    /**
     * Wiki has many documents
     */
    public function documents()
    {
        return $this->hasMany('App\Document');
    }

     /**
     * Wiki belongs to one user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Wiki has many actions
     */
    public function actions()
    {
        return $this->hasMany('App\Action');
    }
}
