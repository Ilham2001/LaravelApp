<?php

namespace App\Http\DTO;

class ActionDTO
{
    protected $attributes = [
        'id',
        'type',
        'user',
        'project',
        'article',
        'wiki',
        'created_at',
        'updated_at'
    ];
}