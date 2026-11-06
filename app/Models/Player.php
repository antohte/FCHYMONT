<?php

namespace App\Models;

use App\Enums\PlayerPosition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Player extends Model
{
    protected $fillable = [
        'source_key', 'display_name', 'first_name', 'last_name', 'birth_date',
        'position', 'position_label', 'number', 'photo_path', 'is_published', 'goals', 'saves', 'show_goals', 'show_saves',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'position' => PlayerPosition::class,
            'number' => 'integer',
            'show_goals' => 'boolean',
            'show_saves' => 'boolean',
            'goals' => 'integer',
            'saves' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function publicData(): array
    {
        return [
            'id' => $this->id,
            'displayName' => $this->display_name,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'age' => $this->birth_date && $this->birth_date->isPast() ? $this->birth_date->age : null,
            'position' => $this->position->value,
            'positionLabel' => $this->position_label,
            'positionCode' => $this->position->abbreviation(),
            'number' => $this->number,
            'photoUrl' => $this->photo_path ? Storage::disk('public')->url($this->photo_path) : null,
            'statistics' => array_values(array_filter([
                $this->show_goals && $this->goals !== null ? ['label' => 'Buts', 'value' => $this->goals] : null,
                $this->show_saves && $this->saves !== null ? ['label' => 'Arrêts', 'value' => $this->saves] : null,
            ])),
        ];
    }
}
