<?php

namespace App\Http\DTO;

class SearchResultDTO
{
    protected $attributes = [
        'projects',
        'articles',
        'wikis',
        'result_length',
        'projects_length',
        'articles_length',
        'wikis_length'
    ];
}