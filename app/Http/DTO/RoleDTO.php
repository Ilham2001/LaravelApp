<?php

namespace App\Http\DTO;

class RoleDTO
{
    protected $attributes = [
        'id',
        'name',
        'permissions',
        'users'
    ];
}