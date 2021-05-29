<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = "users";
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email', 
        'password',
        'landing_page',
        'role_id'
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
        return $this->belongsTo('App\Role');
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

    /**
     * User has many articles
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

      /**
     * User has many wikis
     */
    public function wikis()
    {
        return $this->hasMany('App\Wiki');
    }

    /**
     * User has many actions
     */
    public function actions()
    {
        return $this->hasMany('App\Action');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}