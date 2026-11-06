<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    protected $fillable = ['status', 'placements', 'show_goals', 'show_saves', 'published_at'];

    protected function casts(): array
    {
        return [
            'placements' => 'array',
            'show_goals' => 'boolean',
            'show_saves' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}
