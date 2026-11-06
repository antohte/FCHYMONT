<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Selection;
use Inertia\Inertia;
use Inertia\Response;

class SelectionController extends Controller
{
    public function __invoke(): Response
    {
        $selection = Selection::where('status', 'published')
            ->whereNotNull('published_at')->where('published_at', '<=', now())
            ->orderByDesc('published_at')->orderByDesc('id')->first();
        $preview = ! $selection && ! Selection::exists() && config('selection.preview');
        $placements = $selection?->placements ?? ($preview ? config('selection.preview_placements') : []);
        $players = Player::where('is_published', true)->get();
        $entries = [];
        $seen = [];

        foreach ($placements as $placement) {
            $player = $preview
                ? $players->firstWhere('source_key', $placement['key'] ?? null)
                : $players->firstWhere('id', $placement['player_id'] ?? null);
            if (! $player || isset($seen[$player->id])) {
                continue;
            }
            $bench = (bool) ($placement['bench'] ?? false);
            if (! $bench && (! is_numeric($placement['x'] ?? null) || ! is_numeric($placement['y'] ?? null))) {
                continue;
            }
            $seen[$player->id] = true;
            $data = $player->publicData();
            $entries[] = [
                'player' => $data,
                'bench' => $bench,
                'x' => $bench ? null : max(12, min(88, (float) $placement['x'])),
                'y' => $bench ? null : max(16, min(94, (float) $placement['y'])),
            ];
        }

        return Inertia::render('Selection', ['entries' => $entries, 'preview' => (bool) $preview]);
    }
}
