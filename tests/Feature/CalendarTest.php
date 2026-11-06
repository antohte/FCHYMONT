<?php

namespace Tests\Feature;

use App\Models\Fixture;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $changes = []): array
    {
        return array_replace(['opponent_name' => 'Adversaire de test', 'match_date' => '2026-11-22', 'kickoff_time' => '14:30', 'competition' => 'Compétition de test', 'venue' => 'Terrain de test', 'is_home' => true, 'status' => 'scheduled', 'club_score' => null, 'opponent_score' => null, 'is_published' => false], $changes);
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }

    public function test_empty_calendar_is_public(): void
    {
        $this->get('/calendrier')->assertOk()->assertInertia(fn (Assert $page) => $page->component('Calendar')->has('fixtures', 0)->has('today')->has('currentTime'));
    }

    public function test_only_published_fixtures_are_public_and_chronological(): void
    {
        Fixture::create($this->payload());
        Fixture::create($this->payload(['is_published' => true, 'status' => 'finished', 'club_score' => 0, 'opponent_score' => 0, 'match_date' => '2026-10-25']));
        Fixture::create($this->payload(['is_published' => true]));
        $this->get('/calendrier')->assertInertia(fn (Assert $page) => $page->component('Calendar')->has('fixtures', 2)->where('fixtures.0.date', '2026-10-25')->where('fixtures.0.clubScore', 0)->where('fixtures.0.opponentScore', 0)->missing('fixtures.0.is_published')->missing('fixtures.0.created_at'));
    }

    public function test_guests_and_non_administrators_cannot_manage_any_fixture(): void
    {
        $fixture = Fixture::create($this->payload());
        $this->get('/admin/calendrier')->assertRedirect('/login');
        $this->post('/admin/calendrier', $this->payload())->assertRedirect('/login');
        $this->put('/admin/calendrier/'.$fixture->id, $this->payload())->assertRedirect('/login');
        $this->delete('/admin/calendrier/'.$fixture->id)->assertRedirect('/login');
        $this->actingAs(User::factory()->create());
        $this->get('/admin/calendrier')->assertForbidden();
        $this->post('/admin/calendrier', $this->payload())->assertForbidden();
        $this->put('/admin/calendrier/'.$fixture->id, $this->payload())->assertForbidden();
        $this->delete('/admin/calendrier/'.$fixture->id)->assertForbidden();
        $this->assertDatabaseCount('fixtures', 1);
    }

    public function test_admin_can_create_publish_edit_unpublish_and_delete_a_match(): void
    {
        $this->actingAs($this->admin());
        $this->post('/admin/calendrier', $this->payload())->assertRedirect('/admin/calendrier');
        $fixture = Fixture::firstOrFail();
        $this->get('/admin/calendrier')->assertInertia(fn (Assert $page) => $page->component('Admin/Calendar')->has('fixtures', 1)->where('fixtures.0.published', false));
        $this->put('/admin/calendrier/'.$fixture->id, $this->payload(['status' => 'finished', 'club_score' => 0, 'opponent_score' => 2, 'is_published' => true, 'is_home' => false]))->assertSessionHasNoErrors()->assertRedirect('/admin/calendrier');
        $this->assertDatabaseHas('fixtures', ['id' => $fixture->id, 'club_score' => 0, 'opponent_score' => 2, 'is_home' => false, 'is_published' => true]);
        $this->get('/calendrier')->assertInertia(fn (Assert $page) => $page->has('fixtures', 1));
        $this->put('/admin/calendrier/'.$fixture->id, $this->payload(['status' => 'postponed']))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('fixtures', ['id' => $fixture->id, 'status' => 'postponed', 'club_score' => null, 'is_published' => false]);
        $this->get('/calendrier')->assertInertia(fn (Assert $page) => $page->has('fixtures', 0));
        $this->delete('/admin/calendrier/'.$fixture->id)->assertRedirect('/admin/calendrier');
        $this->assertDatabaseCount('fixtures', 0);
    }

    public function test_invalid_dates_times_statuses_and_scores_are_rejected(): void
    {
        $this->actingAs($this->admin());
        $this->post('/admin/calendrier', $this->payload(['match_date' => '2026-02-30', 'kickoff_time' => '25:10', 'status' => 'unknown']))->assertSessionHasErrors(['match_date', 'kickoff_time', 'status']);
        $this->post('/admin/calendrier', $this->payload(['status' => 'finished']))->assertSessionHasErrors(['club_score', 'opponent_score']);
        $this->post('/admin/calendrier', $this->payload(['status' => 'finished', 'club_score' => -1, 'opponent_score' => 1.5]))->assertSessionHasErrors(['club_score', 'opponent_score']);
        $this->post('/admin/calendrier', $this->payload(['club_score' => 0]))->assertSessionHasErrors(['club_score']);
        $this->assertDatabaseCount('fixtures', 0);
    }

    public function test_kickoff_and_venue_are_optional_and_cancelled_matches_can_be_published(): void
    {
        $this->actingAs($this->admin())->post('/admin/calendrier', $this->payload(['kickoff_time' => null, 'venue' => null, 'status' => 'cancelled', 'is_published' => true]))->assertSessionHasNoErrors();
        $this->get('/calendrier')->assertInertia(fn (Assert $page) => $page->where('fixtures.0.status', 'cancelled')->where('fixtures.0.time', null));
    }

    public function test_registration_cannot_grant_admin_privileges(): void
    {
        $this->post('/register', ['name' => 'Compte de test', 'email' => 'compte@example.test', 'password' => 'password-test', 'password_confirmation' => 'password-test', 'is_admin' => true])->assertSessionHasNoErrors();
        $this->assertFalse(User::where('email', 'compte@example.test')->firstOrFail()->is_admin);
    }

    public function test_admin_command_grants_and_revokes_only_existing_accounts(): void
    {
        $user = User::factory()->create();
        $this->artisan('club:admin', ['email' => $user->email])->assertSuccessful();
        $this->assertTrue($user->fresh()->is_admin);
        $this->artisan('club:admin', ['email' => $user->email, '--revoke' => true])->assertSuccessful();
        $this->assertFalse($user->fresh()->is_admin);
        $this->artisan('club:admin', ['email' => 'absent@example.test'])->assertFailed();
        $this->assertDatabaseCount('users', 1);
    }
}
