<?php

namespace Tests\Feature;

use App\Models\Fixture;
use App\Models\Player;
use App\Models\Selection;
use App\Models\User;
use App\Support\SelectionSlots;
use Database\Seeders\ClubCalendarSeeder;
use Database\Seeders\ClubRosterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ClubAdministrationTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }

    private function playerData(array $changes = []): array
    {
        return array_replace(['display_name' => 'Joueur de test', 'first_name' => null, 'last_name' => null,
            'birth_date' => null, 'position' => 'forward', 'position_label' => 'Attaquant', 'number' => 9,
            'goals' => null, 'saves' => null, 'is_published' => true], $changes);
    }

    public function test_import_contains_real_past_and_future_matches_without_overwriting_admin_edits(): void
    {
        $this->seed(ClubCalendarSeeder::class);
        $this->assertDatabaseCount('fixtures', 21);
        $this->assertSame(10, Fixture::where('status', 'finished')->count());
        $this->assertSame(11, Fixture::where('status', 'scheduled')->count());
        $next = Fixture::whereDate('match_date', '2026-11-08')->firstOrFail();
        $this->assertSame('AS Girmont', $next->opponent_name);
        $this->assertSame('14:30', $next->kickoff_time);
        $this->assertFalse($next->is_home);
        $this->assertSame('LSC Portieux', Fixture::whereDate('match_date', '2027-05-23')->firstOrFail()->opponent_name);
        $this->assertDatabaseHas('fixtures', ['id' => Fixture::whereDate('match_date', '2026-09-27')->firstOrFail()->id, 'outcome' => 'loss', 'club_score' => null, 'kickoff_time' => null]);
        $next->update(['venue' => 'Lieu modifié par le club', 'is_published' => false]);
        $this->seed(ClubCalendarSeeder::class);
        $this->assertDatabaseCount('fixtures', 21);
        $this->assertSame('Lieu modifié par le club', $next->fresh()->venue);
        $this->assertFalse($next->fresh()->is_published);
        $this->get('/calendrier')->assertInertia(fn (Assert $page) => $page->has('fixtures', 20)->missing('fixtures.0.source_key'));
    }

    public function test_result_without_score_is_editable_and_incomplete_score_is_rejected(): void
    {
        $this->seed(ClubCalendarSeeder::class);
        $fixture = Fixture::where('status', 'finished')->firstOrFail();
        $data = $fixture->only(['opponent_name', 'match_date', 'kickoff_time', 'competition', 'venue', 'is_home', 'status', 'outcome', 'club_score', 'opponent_score', 'is_published']);
        $data['match_date'] = $fixture->match_date->format('Y-m-d');
        $this->actingAs($this->admin())->put('/admin/calendrier/'.$fixture->id, $data)->assertSessionHasNoErrors();
        $data['club_score'] = 2;
        $this->put('/admin/calendrier/'.$fixture->id, $data)->assertSessionHasErrors('opponent_score');
    }

    public function test_all_management_routes_reject_guests_and_non_admins(): void
    {
        $player = Player::create($this->playerData());
        $routes = [['get', '/admin/joueurs'], ['post', '/admin/joueurs'], ['put', '/admin/joueurs/'.$player->id], ['delete', '/admin/joueurs/'.$player->id], ['get', '/admin/convocation'], ['put', '/admin/convocation'], ['delete', '/admin/convocation']];
        foreach ($routes as [$method, $url]) {
            $this->{$method}($url)->assertRedirect('/login');
        }
        $this->actingAs(User::factory()->create());
        foreach ($routes as [$method, $url]) {
            $this->{$method}($url)->assertForbidden();
        }
        $this->assertDatabaseCount('players', 1);
    }

    public function test_player_create_update_publication_and_photo_cleanup(): void
    {
        Storage::fake('public');
        $this->actingAs($this->admin());
        // A real tiny PNG, independent of the optional GD extension.
        $photo = fn () => UploadedFile::fake()->createWithContent('portrait.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/l9sAAAAASUVORK5CYII='));
        $this->post('/admin/joueurs', $this->playerData(['photo' => $photo(), 'first_name' => 'Prénom de test', 'last_name' => 'Nom de test', 'birth_date' => '2000-01-01', 'goals' => 0, 'is_admin' => true, 'source_key' => 'injected']))->assertSessionHasNoErrors();
        $player = Player::firstOrFail();
        $this->assertNull($player->source_key);
        Storage::disk('public')->assertExists($player->photo_path);
        $old = $player->photo_path;
        $this->put('/admin/joueurs/'.$player->id, $this->playerData(['photo' => $photo(), 'is_published' => false]))->assertSessionHasNoErrors();
        Storage::disk('public')->assertMissing($old);
        $player->refresh();
        Storage::disk('public')->assertExists($player->photo_path);
        $this->get('/equipe')->assertInertia(fn (Assert $page) => $page->has('players', 0));
        $this->put('/admin/joueurs/'.$player->id, $this->playerData(['remove_photo' => true]))->assertSessionHasNoErrors();
        Storage::disk('public')->assertMissing($player->photo_path);
        $this->assertNull($player->fresh()->photo_path);
        $this->get('/admin/joueurs')->assertInertia(fn (Assert $page) => $page->component('Admin/Players')->has('players', 1));
        $this->get('/equipe')->assertInertia(fn (Assert $page) => $page->has('players', 1)->missing('players.0.birthDate')->missing('players.0.birth_date')->missing('players.0.goals'));
        Selection::create(['placements' => [['player_id' => $player->id, 'bench' => true]]]);
        $this->delete('/admin/joueurs/'.$player->id)->assertRedirect('/admin/joueurs');
        $this->assertDatabaseCount('players', 0);
        $this->assertSame([], Selection::firstOrFail()->placements);
    }

    public function test_player_validation_rejects_future_birth_invalid_positions_and_non_image_uploads(): void
    {
        $this->actingAs($this->admin())->post('/admin/joueurs', $this->playerData(['birth_date' => now()->addDay()->format('Y-m-d'), 'position' => 'unknown', 'goals' => -1, 'number' => 0, 'photo' => UploadedFile::fake()->createWithContent('portrait.svg', '<svg></svg>')]))->assertSessionHasErrors(['birth_date', 'position', 'goals', 'number', 'photo']);
        $this->assertDatabaseCount('players', 0);
    }

    public function test_draft_is_private_publication_is_explicit_and_withdrawal_keeps_draft(): void
    {
        config(['selection.preview' => true]);
        $this->seed(ClubRosterSeeder::class);
        $players = Player::take(2)->get();
        $first = [['player_id' => $players[0]->id, 'bench' => false, 'x' => 50, 'y' => 94]];
        $second = [['player_id' => $players[1]->id, 'bench' => false, 'x' => 34, 'y' => 56]];
        $this->actingAs($this->admin());
        $this->put('/admin/convocation', ['action' => 'draft', 'placements' => $first])->assertSessionHasNoErrors();
        $this->get('/convocation')->assertInertia(fn (Assert $page) => $page->has('entries', 0)->where('preview', false));
        $this->put('/admin/convocation', ['action' => 'publish', 'placements' => $first])->assertSessionHasNoErrors();
        $this->put('/admin/convocation', ['action' => 'draft', 'placements' => $second])->assertSessionHasNoErrors();
        $this->get('/convocation')->assertInertia(fn (Assert $page) => $page->where('entries.0.player.id', $players[0]->id));
        $this->get('/admin/convocation')->assertInertia(fn (Assert $page) => $page->component('Admin/Selection')->where('placements.0.player_id', $players[1]->id));
        $this->put('/admin/convocation', ['action' => 'publish', 'placements' => $second])->assertSessionHasNoErrors();
        $this->assertSame(1, Selection::where('status', 'published')->count());
        $this->get('/convocation')->assertInertia(fn (Assert $page) => $page->where('entries.0.player.id', $players[1]->id));
        $this->delete('/admin/convocation')->assertRedirect('/admin/convocation');
        $this->assertSame(1, Selection::where('status', 'draft')->count());
        $this->get('/convocation')->assertInertia(fn (Assert $page) => $page->has('entries', 0)->where('preview', false));
    }

    public function test_composition_rejects_duplicates_hidden_players_missing_coordinates_and_over_eleven_starters(): void
    {
        $this->seed(ClubRosterSeeder::class);
        $this->actingAs($this->admin());
        $players = Player::take(12)->get();
        $entry = ['player_id' => $players[0]->id, 'bench' => false, 'x' => 50, 'y' => 50];
        $this->put('/admin/convocation', ['action' => 'publish', 'placements' => [$entry, $entry]])->assertSessionHasErrors('placements.0.player_id');
        $players[0]->update(['is_published' => false]);
        $this->put('/admin/convocation', ['action' => 'draft', 'placements' => [$entry]])->assertSessionHasErrors('placements.0.player_id');
        $players[0]->update(['is_published' => true]);
        $this->put('/admin/convocation', ['action' => 'draft', 'placements' => [array_replace($entry, ['x' => null])]])->assertSessionHasErrors('placements.0.x');
        $this->put('/admin/convocation', ['action' => 'draft', 'placements' => [array_replace($entry, ['x' => 999])]])->assertSessionHasErrors('placements.0.x');
        $this->put('/admin/convocation', ['action' => 'publish', 'placements' => $players->map(fn ($player) => array_replace($entry, ['player_id' => $player->id]))->all()])->assertSessionHasErrors('placements');
        $this->put('/admin/convocation', ['action' => 'publish', 'placements' => []])->assertSessionHasErrors('placements');
        $this->assertDatabaseCount('selections', 0);
        $this->put('/admin/convocation', ['action' => 'draft', 'placements' => []])->assertSessionHasNoErrors();
    }

    public function test_player_statistic_visibility_is_individual_and_shared_by_public_pages(): void
    {
        $player = Player::create($this->playerData(['goals' => 0, 'saves' => null]));
        $other = Player::create($this->playerData(['goals' => 8, 'number' => 10]));
        Selection::create(['status' => 'published', 'published_at' => now(), 'placements' => [
            ['player_id' => $player->id, 'bench' => true],
            ['player_id' => $other->id, 'bench' => true],
        ]]);
        $this->actingAs($this->admin());
        foreach ([true, false] as $visible) {
            $this->put('/admin/joueurs/'.$player->id, $this->playerData([
                'goals' => 0, 'show_goals' => $visible, 'show_saves' => true,
            ]))->assertSessionHasNoErrors();
            $this->assertSame($visible, $player->fresh()->show_goals);
            $expected = $visible ? [['label' => 'Buts', 'value' => 0]] : [];
            $this->get('/convocation')->assertInertia(fn (Assert $page) => $page
                ->where('entries.0.player.statistics', $expected)
                ->where('entries.1.player.statistics', [])
                ->missing('entries.0.player.goals')->missing('entries.0.player.saves'));
            $this->get('/equipe')->assertInertia(fn (Assert $page) => $page
                ->where('players.0.statistics', $expected)->where('players.1.statistics', []));
        }
        $this->put('/admin/joueurs/'.$player->id, $this->playerData([
            'goals' => 2, 'saves' => 5, 'show_goals' => true, 'show_saves' => true,
        ]))->assertSessionHasNoErrors();
        $this->get('/equipe')->assertInertia(fn (Assert $page) => $page
            ->where('players.0.statistics', [['label' => 'Buts', 'value' => 2], ['label' => 'Arrêts', 'value' => 5]]));
        $this->put('/admin/joueurs/'.$player->id, $this->playerData(['show_goals' => 'invalid']))
            ->assertSessionHasErrors('show_goals');
        $this->get('/admin/convocation')->assertInertia(fn (Assert $page) => $page->missing('settings'));
        $this->put('/admin/statistiques', [])->assertNotFound();
    }

    public function test_fixed_slots_reject_free_coordinates_and_two_players_on_the_same_place(): void
    {
        $this->seed(ClubRosterSeeder::class);
        $players = Player::take(2)->get();
        $this->actingAs($this->admin());
        $entry = ['player_id' => $players[0]->id, 'bench' => false, 'x' => 50, 'y' => 50];
        $this->put('/admin/convocation', ['action' => 'draft', 'placements' => [$entry]])->assertSessionHasErrors('placements.0.x');
        $slot = config('selection.slots')[0];
        $entry['x'] = $slot['x'];
        $entry['y'] = $slot['y'];
        $other = array_replace($entry, ['player_id' => $players[1]->id]);
        $this->put('/admin/convocation', ['action' => 'draft', 'placements' => [$entry, $other]])->assertSessionHasErrors('placements');
        $this->assertDatabaseCount('selections', 0);
        $other['x'] = config('selection.slots')[1]['x'];
        $other['y'] = config('selection.slots')[1]['y'];
        $this->put('/admin/convocation', ['action' => 'publish', 'placements' => [$entry, $other]])->assertSessionHasNoErrors();
        $this->get('/convocation')->assertInertia(fn (Assert $page) => $page->where('entries.0.x', $slot['x'])->where('entries.1.x', $other['x']));
    }

    public function test_existing_free_placements_are_repositioned_without_overwriting_saved_data(): void
    {
        $this->seed(ClubRosterSeeder::class);
        $players = Player::take(3)->get();
        $old = $players->map(fn ($player) => ['player_id' => $player->id, 'bench' => false, 'x' => 50, 'y' => 50])->all();
        $selection = Selection::create(['status' => 'draft', 'placements' => $old]);
        $this->actingAs($this->admin())->get('/admin/convocation')->assertInertia(function (Assert $page) {
            $page->has('slots', 11)->has('placements', 3)->where('placements', function ($placements) {
                $places = collect($placements)->map(fn ($entry) => $entry['x'].':'.$entry['y']);
                $this->assertSame(3, $places->unique()->count());
                foreach ($placements as $entry) {
                    $this->assertNotNull(SelectionSlots::find($entry));
                }

                return true;
            });
        });
        $this->assertSame($old, $selection->fresh()->placements);
    }
}
