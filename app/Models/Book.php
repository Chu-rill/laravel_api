<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';

    protected $casts = [
        'id' => 'string',
        'borrowed' => 'boolean'
    ];

    protected $fillable = [
        'title',
        'author',
        'description',
        "borrowed",
        'published_year'
    ];
    protected static function boot()
    {
        parent::boot();

        // static::creating(function ($model) {
        //         $model->id = (string) Str::uuid();
        // });
    }
}
