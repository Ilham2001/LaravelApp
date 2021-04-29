<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $table = "permissions";
    protected $fillable = [
        'id',
        'name',
        'slug'
    ];
    
    /**
     * Permission belongs to many roles
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
