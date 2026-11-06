<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    protected $fillable = ['source_key', 'outcome', 'opponent_name', 'match_date', 'kickoff_time', 'competition', 'venue', 'is_home', 'status', 'club_score', 'opponent_score', 'is_published'];

    protected function casts(): array
    {
        return ['match_date' => 'date', 'is_home' => 'boolean', 'is_published' => 'boolean', 'club_score' => 'integer', 'opponent_score' => 'integer'];
    }

    public function publicData(): array
    {
        return ['outcome' => $this->outcome, 'id' => $this->id, 'opponent' => $this->opponent_name, 'date' => $this->match_date->format('Y-m-d'), 'time' => $this->kickoff_time, 'competition' => $this->competition, 'venue' => $this->venue, 'home' => $this->is_home, 'status' => $this->status, 'clubScore' => $this->club_score, 'opponentScore' => $this->opponent_score];
    }
}
