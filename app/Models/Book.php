<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    
    protected $guarded = [
        'title',
        'cover',
        'author',
        'genre',
        'themes',
        'series',
        'description',
        'isbn',
        'publisher',
        'pages',
        'users_rating',
    ];
}
