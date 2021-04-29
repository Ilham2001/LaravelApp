<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email', 
        'password',
        'landing_page'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * User belongs to one role
     */
    public function role()
    {
        return $this->belongdTo('App\Role');
    }

    /**
     * User has many projects
     */
    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    /**
     * User is member in many projects
     */
    public function projects_member(Type $var = null)
    {
        return $this->belongsToMany('App\Project');
    }
}