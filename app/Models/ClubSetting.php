<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubSetting extends Model
{
    public $timestamps = false;

    protected $fillable = ['show_goals', 'show_saves'];

    protected function casts(): array
    {
        return ['show_goals' => 'boolean', 'show_saves' => 'boolean'];
    }
}
