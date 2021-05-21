<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public $table = "documents";
    protected $fillable = [
        'id',
        'title',
        'reference',
        'wiki_id',
        'article_id'
    ];

    /**
     * Document belongs to one wiki
     */
    public function wiki()
    {
        return $this->belongsTo('App\Wiki');
    }

    /**
     * Document belongs to one article
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}
