<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reservation extends Model
{
    protected $casts = [
        'reserved_at' => 'datetime',
       
    ];
    protected $fillable = [
        'id',
        'user_id',
        'book_id',
        'reserved_at',
        "due_date",
        'status'
    ];

    public $incrementing = false; // Inform Eloquent the primary key is not auto-incrementing
    protected $keyType = 'string'; // Set the key type to string for UUID

    protected static function boot()
    {
        parent::boot();

        // Automatically generate UUID for the id field
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString();
            }
        });
    }
}
