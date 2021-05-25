<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $table = "articles";
    protected $fillable = [
        'id',
        'title',
        'summary',
        'environment',
        'description',
        'error_message',
        'ticket_number',
        'cause',
        'resolution',
        'keywords',
        'workaround',
        'category_id',
        'user_id'
    ];

    /**
     * Article belongs to one category
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Article has many documents
     */
    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    /**
     * Article belongs to one user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
