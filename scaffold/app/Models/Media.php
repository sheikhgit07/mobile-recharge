<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'disk',
        'path',
        'title',
        'alt_text',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}