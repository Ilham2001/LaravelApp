<?php

namespace App\Http\DTO;

class ArticleDTO
{
    protected $attributes = [
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
        'author',
        'documents',
        'created_at',
        'updated_at'
    ];
}