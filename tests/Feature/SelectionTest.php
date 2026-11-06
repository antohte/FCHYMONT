<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Selection;
use Database\Seeders\ClubRosterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class SelectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_publication_does_not_expose_drafts_or_future_publications(): void
    {
        config(['selection.preview' => false]);
        Selection::create(['status' => 'draft', 'placements' => [], 'published_at' => now()]);
        Selection::create(['status' => 'published', 'placements' => [], 'published_at' => now()->addDay()]);
        $this->get('/convocation')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Selection')->has('entries', 0)->where('preview', false));
    }

    public function test_local_preview_is_explicit_and_contains_no_invented_statistics(): void
    {
        config(['selection.preview' => true]);
        $this->seed(ClubRosterSeeder::class);
        $this->get('/convocation')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Selection')->where('preview', true)->has('entries', 14)
            ->where('entries.0.bench', false)->where('entries.11.bench', true)
            ->where('entries.0.player.age', null)->where('entries.0.player.statistics', []));
    }

    public function test_latest_publication_filters_hidden_missing_and_duplicate_players_and_bounds_coordinates(): void
    {
        config(['selection.preview' => true]);
        $this->seed(ClubRosterSeeder::class);
        $keeper = Player::where('position', 'goalkeeper')->firstOrFail();
        $hidden = Player::where('position', 'forward')->firstOrFail();
        $hidden->update(['is_published' => false]);
        Selection::create(['status' => 'published', 'placements' => [], 'published_at' => now()->subDays(2)]);
        Selection::create(['status' => 'published', 'published_at' => now()->subDay(), 'placements' => [
            ['player_id' => $keeper->id, 'x' => -500, 'y' => 999],
            ['player_id' => $keeper->id, 'bench' => true],
            ['player_id' => $hidden->id, 'bench' => true],
            ['player_id' => 99999, 'bench' => true],
        ]]);
        $this->get('/convocation')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->where('preview', false)->has('entries', 1)
            ->where('entries.0.player.id', $keeper->id)->where('entries.0.x', 12)->where('entries.0.y', 94)
            ->missing('entries.0.player.birth_date')->missing('entries.0.player.source_key')
            ->missing('entries.0.player.goals')->missing('entries.0.player.saves'));
    }

    public function test_statistics_are_hidden_by_default_and_expose_only_the_enabled_relevant_total(): void
    {
        $this->seed(ClubRosterSeeder::class);
        $keeper = Player::where('position', 'goalkeeper')->firstOrFail();
        $forward = Player::where('position', 'forward')->firstOrFail();
        $keeper->update(['saves' => 12, 'goals' => 3]);
        $forward->update(['goals' => 0, 'saves' => 7]);
        Selection::create(['status' => 'published', 'published_at' => now(), 'placements' => [
            ['player_id' => $keeper->id, 'x' => 50, 'y' => 90],
            ['player_id' => $forward->id, 'bench' => true],
        ]]);
        $this->get('/convocation')->assertInertia(fn (Assert $page) => $page
            ->where('entries.0.player.statistics', [])->where('entries.1.player.statistics', []));
        $forward->update(['show_goals' => true]);
        $this->get('/convocation')->assertInertia(fn (Assert $page) => $page
            ->where('entries.0.player.statistics', [])->where('entries.1.player.statistics', [['label' => 'Buts', 'value' => 0]]));
        $keeper->update(['show_saves' => true]);
        $this->get('/convocation')->assertInertia(fn (Assert $page) => $page
            ->where('entries.0.player.statistics', [['label' => 'Arrêts', 'value' => 12]]));
    }
}
