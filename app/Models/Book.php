<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
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
