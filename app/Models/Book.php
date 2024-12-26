<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $casts = [
        'borrowed' => 'boolean'
    ];

    protected $fillable = [
        'title',
        'author',
        'description',
        "borrowed",
        'published_year'
    ];
}
