<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PlayerPosition;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerRequest;
use App\Models\Player;
use App\Models\Selection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PlayersController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/Players', [
            'players' => Player::orderBy('number')->orderBy('id')->get()->map(fn (Player $player) => [
                ...$player->publicData(), 'birthDate' => $player->birth_date?->format('Y-m-d'),
                'showGoals' => $player->show_goals, 'showSaves' => $player->show_saves,
                'published' => $player->is_published, 'goals' => $player->goals, 'saves' => $player->saves,
            ]),
            'positions' => array_map(fn ($position) => ['value' => $position->value, 'label' => $position->label()], PlayerPosition::cases()),
            'notice' => $request->session()->get('club_notice'),
        ]);
    }

    public function store(PlayerRequest $request)
    {
        return $this->persist($request, new Player);
    }

    public function update(PlayerRequest $request, Player $player)
    {
        return $this->persist($request, $player);
    }

    private function persist(PlayerRequest $request, Player $player)
    {
        $data = $request->safe()->except(['photo', 'remove_photo']);
        $old = $player->photo_path;
        $new = $request->file('photo')?->store('players', 'public');
        if ($request->hasFile('photo') && ! $new) {
            throw ValidationException::withMessages(['photo' => 'Le portrait n’a pas pu être enregistré. Réessayez.']);
        }
        if ($new || $request->boolean('remove_photo')) {
            $data['photo_path'] = $new ?: null;
        }
        try {
            $player->fill($data)->save();
        } catch (\Throwable $exception) {
            if ($new) {
                Storage::disk('public')->delete($new);
            }
            throw $exception;
        }
        if ($old && ($new || $request->boolean('remove_photo'))) {
            Storage::disk('public')->delete($old);
        }

        return to_route('admin.players.index')->with('club_notice', 'La fiche du joueur a été enregistrée.');
    }

    public function destroy(Player $player)
    {
        $photo = $player->photo_path;
        DB::transaction(function () use ($player) {
            foreach (Selection::lockForUpdate()->get() as $selection) {
                $selection->update(['placements' => array_values(array_filter($selection->placements, fn ($entry) => ($entry['player_id'] ?? null) !== $player->id))]);
            }
            $player->delete();
        });
        if ($photo) {
            Storage::disk('public')->delete($photo);
        }

        return to_route('admin.players.index')->with('club_notice', 'Le joueur a été supprimé de l’effectif et des compositions.');
    }
}
