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
        'category_id'
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
}
