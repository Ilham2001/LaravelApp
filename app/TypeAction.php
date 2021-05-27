<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeAction extends Model
{
    public $table = "type_actions";
    protected $fillable = [
        'id',
        'name',
        'code'
    ];

    /**
     * Type belongs to many actions
     */
    public function actions()
    {
        return $this->belongsToMany('App\Action','type_id');
    }
}
