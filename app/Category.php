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
}
