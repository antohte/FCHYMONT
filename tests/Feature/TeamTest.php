<?php

namespace Tests\Feature;

use App\Models\Player;
use Database\Seeders\ClubRosterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_team_is_publicly_accessible(): void
    {
        $this->get('/equipe')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Team')->has('players', 0)->has('positions', 4));
    }

    public function test_only_published_players_and_public_fields_are_exposed(): void
    {
        Player::create([
            'display_name' => 'Joueur de test', 'position' => 'goalkeeper',
            'position_label' => 'Gardien de but', 'number' => 1, 'is_published' => true,
        ]);
        Player::create([
            'display_name' => 'Brouillon de test', 'position' => 'forward',
            'position_label' => 'Attaquant', 'is_published' => false,
        ]);

        $this->get('/equipe')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Team')->has('players', 1)
            ->where('players.0.displayName', 'Joueur de test')
            ->where('players.0.age', null)->where('players.0.photoUrl', null)
            ->missing('players.0.birth_date')->missing('players.0.source_key')
            ->missing('players.0.goals')->missing('players.0.saves'));
    }

    public function test_public_roster_can_be_imported_twice_without_duplicates_or_overwriting_edits(): void
    {
        $this->seed(ClubRosterSeeder::class);
        Player::where('source_key', 'hymont-leo-b')->update(['number' => 16]);
        $this->seed(ClubRosterSeeder::class);

        $this->assertDatabaseCount('players', 26);
        $this->assertDatabaseHas('players', ['source_key' => 'hymont-leo-b', 'number' => 16]);
        $this->assertSame(1, Player::where('position', 'goalkeeper')->count());
        $this->assertSame(10, Player::where('position', 'defender')->count());
        $this->assertSame(7, Player::where('position', 'midfielder')->count());
        $this->assertSame(8, Player::where('position', 'forward')->count());
        $this->assertSame(0, Player::whereNotNull('birth_date')->count());
    }
}
