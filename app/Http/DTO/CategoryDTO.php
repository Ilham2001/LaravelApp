<?php

namespace App\Http\DTO;

class CategoryDTO
{
    protected $attributes = [
        'id',
        'title',
        'description',
        'projects',
        'articles',
        'parent_id',
        'children',
        'articles_length'
    ];
}