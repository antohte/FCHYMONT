<?php

namespace App\Http\Controllers;

use App\Enums\PlayerPosition;
use App\Models\Player;
use Inertia\Inertia;
use Inertia\Response;

class TeamController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Team', [
            'players' => Player::query()->where('is_published', true)
                ->orderBy('number')->orderBy('display_name')
                ->get()->map(fn (Player $player) => $player->publicData())->values(),
            'positions' => array_map(fn (PlayerPosition $position) => [
                'value' => $position->value,
                'label' => $position->label(),
            ], PlayerPosition::cases()),
        ]);
    }
}
