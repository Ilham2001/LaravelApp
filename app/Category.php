<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = "categories";
    protected $fillable = [
        'id',
        'title',
        'description'
    ];

    /**
     * Category belongs to many projects
     */
    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }

    /**
     * Category has many articles
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    /**
     * Category belongs to one parent category
     */
    public function parent()
    {
        return $this->belongsTo('App\Category','parent_id');
    }

    /**
     * Category has many category children
     */
    public function children()
    {
        return $this->hasMany('App\Category','parent_id');
    }
}
