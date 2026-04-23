<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'completed',
        'timer_seconds',
        'elapsed_seconds',
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];
}
