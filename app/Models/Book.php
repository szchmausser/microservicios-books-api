<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'author_id',
    ];
}
