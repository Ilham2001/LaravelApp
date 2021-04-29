<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = "roles";
    protected $fillable = [
        'id',
        'name',
        'slug'
    ];

    /**
     * Role has many users
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

     /**
     * Role belongs to many permissions
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }
}
