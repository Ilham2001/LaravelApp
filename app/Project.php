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
        'isClosed'
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
}
