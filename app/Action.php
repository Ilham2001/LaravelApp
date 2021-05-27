<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    public $table = "actions";
    protected $fillable = [
        'id',
        'type_id',
        'user_id'
    ];

    /**
     * Action belongs to one user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Action belongs to one type
     */
    public function type_action()
    {
        return $this->belongsTo('App\TypeAction','type_id');
    }

    /**
     * Action belongs to one project
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

     /**
     * Action belongs to one article
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }

     /**
     * Action belongs to one wiki
     */
    public function wiki()
    {
        return $this->belongsTo('App\Wiki');
    }
}
