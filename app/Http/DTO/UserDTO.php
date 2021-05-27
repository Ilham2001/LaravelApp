<?php

namespace App\Http\DTO;

class UserDTO
{
    protected $attributes = [
        'id',
        'first_name',
        'last_name',
        'email',
        'landing_page',
        'role',
        'role_id',
        'projects_length',
        'articles_length',
        'wikis_length'
    ];
}