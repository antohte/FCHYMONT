<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClubSetting;
use App\Models\Player;
use App\Models\Selection;
use App\Support\SelectionSlots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class SelectionController extends Controller
{
    public function index(Request $request)
    {
        $draft = Selection::where('status', 'draft')->latest('id')->first();
        $published = Selection::where('status', 'published')->latest('published_at')->first();

        $players = Player::where('is_published', true)->orderBy('number')->get();
        $placements = array_values(array_filter($draft?->placements ?? $published?->placements ?? [], fn ($entry) => $players->contains('id', $entry['player_id'] ?? null)));

        return Inertia::render('Admin/Selection', [
            'players' => $players->map->publicData(),
            'placements' => SelectionSlots::normalize($placements),
            'slots' => config('selection.slots'),
            'publishedAt' => $published?->published_at?->toIso8601String(),
            'hasDraft' => (bool) $draft,
            'notice' => $request->session()->get('club_notice'),
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'action' => ['required', Rule::in(['draft', 'publish'])],
            'placements' => ['present', 'array', 'max:50'],
            'placements.*' => ['required', 'array:player_id,bench,x,y'],
            'placements.*.player_id' => ['required', 'integer', 'distinct', Rule::exists('players', 'id')->where('is_published', true)],
            'placements.*.bench' => ['required', 'boolean'],
            'placements.*.x' => ['nullable', 'numeric', 'between:12,88'],
            'placements.*.y' => ['nullable', 'numeric', 'between:16,94'],
        ], [
            'required' => 'Ce champ est obligatoire.', 'present' => 'La composition est manquante.',
            'array' => 'La composition est invalide.', 'max' => 'La composition contient trop de joueurs.',
            'integer' => 'Le joueur est invalide.', 'distinct' => 'Un joueur ne peut figurer qu’une fois.',
            'exists' => 'Ce joueur n’est plus disponible : vérifiez les joueurs publiés.',
            'boolean' => 'Le choix titulaire ou remplaçant est invalide.',
            'numeric' => 'Saisissez une coordonnée numérique.', 'between' => 'La position doit rester dans les limites du terrain.',
            'in' => 'L’action est invalide.',
        ]);
        $starters = count(array_filter($data['placements'], fn ($entry) => ! $entry['bench']));
        if ($starters > 11 || ($data['action'] === 'publish' && $starters === 0)) {
            throw ValidationException::withMessages(['placements' => 'Une publication nécessite de 1 à 11 titulaires ; un brouillon peut rester vide.']);
        }
        $occupied = [];
        foreach ($data['placements'] as $index => &$entry) {
            $entry['player_id'] = (int) $entry['player_id'];
            $entry['bench'] = (bool) $entry['bench'];
            if ($entry['bench']) {
                $entry['x'] = $entry['y'] = null;
            } else {
                if (! isset($entry['x'], $entry['y'])) {
                    throw ValidationException::withMessages(["placements.$index.x" => 'Placez ce titulaire sur le terrain.']);
                }
                $entry['x'] = (float) $entry['x'];
                $entry['y'] = (float) $entry['y'];
                $slot = SelectionSlots::find($entry);
                if (! $slot) {
                    throw ValidationException::withMessages(["placements.$index.x" => 'Choisissez une place prédéfinie sur le terrain.']);
                }
                if (isset($occupied[$slot['id']])) {
                    throw ValidationException::withMessages(['placements' => 'Chaque place ne peut accueillir qu’un seul joueur.']);
                }
                $occupied[$slot['id']] = true;
            }
        }
        unset($entry);
        DB::transaction(function () use ($data) {
            ClubSetting::whereKey(1)->lockForUpdate()->firstOrFail();
            $draft = Selection::where('status', 'draft')->latest('id')->first() ?? new Selection(['status' => 'draft']);
            $draft->fill(['placements' => $data['placements'], 'published_at' => null])->save();
            Selection::where('status', 'draft')->where('id', '!=', $draft->id)->delete();
            if ($data['action'] === 'publish') {
                $published = Selection::where('status', 'published')->latest('id')->first() ?? new Selection(['status' => 'published']);
                $published->fill(['placements' => $data['placements'], 'published_at' => now()])->save();
                Selection::where('status', 'published')->where('id', '!=', $published->id)->delete();
            }
        });

        return to_route('admin.selection.index')->with('club_notice', $data['action'] === 'publish' ? 'La convocation est publiée.' : 'Brouillon enregistré. La convocation publique reste inchangée.');
    }

    public function unpublish()
    {
        DB::transaction(function () {
            ClubSetting::whereKey(1)->lockForUpdate()->firstOrFail();
            Selection::where('status', 'published')->delete();
        });

        return to_route('admin.selection.index')->with('club_notice', 'La convocation a été retirée du site. Le brouillon est conservé.');
    }
}
