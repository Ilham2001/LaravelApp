<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $table = "projects";
    protected $fillable = [
        'id',
        'name',
        'description',
        'website',
        'isPublic',
        'landing_page',
        'isClosed',
        'user_id',
        'parent_id'
    ];

    /**
     * Project has many wikis
     */
    public function wikis()
    {
        return $this->hasMany('App\Wiki');
    }

    /**
     * Project belongs to many categories
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
    /**
     * Project belongs to one user
     */

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Project has many members
     */
    public function members()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Project belongs to one parent project
     */
    public function parent()
    {
        return $this->belongsTo('App\Project','parent_id');
    }

    /**
     * Project has many project children
     */
    public function children()
    {
        return $this->hasMany('App\Project','parent_id');
    }
}
