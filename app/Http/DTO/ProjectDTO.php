<?php

namespace App\Http\DTO;

class ProjectDTO
{
    protected $attributes = [
        'id',
        'name',
        'description',
        'website',
        'isPublic',
        'landing_page',
        'isClosed',
        'user_id',
        'parent_id',
        'members',
        'wikis',
        'categories',
        'articles',
        'articles_length',
        'created_at',
        'updated_at'
    ];
}