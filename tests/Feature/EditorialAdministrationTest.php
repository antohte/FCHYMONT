<?php

namespace Tests\Feature;

use App\Models\ClubContent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class EditorialAdministrationTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }

    private function news(array $extra = []): array
    {
        return array_replace(['title' => 'Une nouvelle du club', 'date' => '2026-11-06', 'excerpt' => 'Le résumé de la nouvelle.', 'paragraphs' => "Premier paragraphe.\n\nDeuxième paragraphe.", 'score' => '', 'opponent' => '', 'sort_order' => 0, 'is_published' => false], $extra);
    }

    public function test_every_admin_section_requires_a_privileged_account(): void
    {
        foreach (['/admin', '/admin/actualites', '/admin/sponsors', '/admin/contacts', '/admin/reseaux', '/admin/joueurs', '/admin/calendrier', '/admin/convocation'] as $url) {
            $this->get($url)->assertRedirect('/login');
        }
        $this->actingAs(User::factory()->create());
        foreach (['/admin', '/admin/actualites', '/admin/sponsors', '/admin/contacts', '/admin/reseaux'] as $url) {
            $this->get($url)->assertForbidden();
        }
        $this->post('/admin/actualites', $this->news())->assertForbidden();
        $entry = ClubContent::where('kind', 'news')->firstOrFail();
        $this->put('/admin/actualites/'.$entry->id, $this->news())->assertForbidden();
        $this->delete('/admin/actualites/'.$entry->id)->assertForbidden();
    }

    public function test_seeded_public_content_and_admin_sections_are_available(): void
    {
        $this->get('/actualites')->assertInertia(fn (Assert $p) => $p->component('News')->has('clubNews', 6)->where('clubNews.0.title', 'Derby remporté facilement'));
        $this->get('/sponsors')->assertInertia(fn (Assert $p) => $p->has('sponsors', 4)->where('sponsors.0.theme', 'planb'));
        $this->get('/contact')->assertInertia(fn (Assert $p) => $p->where('details.contact1_phone', '06 38 71 21 84'));
        $this->get('/reseaux')->assertInertia(fn (Assert $p) => $p->has('networks', 2));
        $this->actingAs($this->admin());
        $this->get('/admin')->assertInertia(fn (Assert $p) => $p->component('Admin/Index'));
        foreach (['actualites' => 'news', 'sponsors' => 'sponsors', 'contacts' => 'contacts', 'reseaux' => 'social'] as $path => $kind) {
            $this->get('/admin/'.$path)->assertInertia(fn (Assert $p) => $p->component('Admin/Content')->where('kind', $kind)->has('fields')->has('items'));
        }
    }

    public function test_news_is_immediately_published_and_uploads_can_be_replaced_and_deleted(): void
    {
        Storage::fake('public');
        $this->actingAs($this->admin());
        $this->post('/admin/actualites', $this->news(['photo' => UploadedFile::fake()->createWithContent('article.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/l9sAAAAASUVORK5CYII='))]))->assertSessionHasNoErrors()->assertRedirect();
        $row = ClubContent::whereNull('source_key')->firstOrFail();
        $this->assertSame(['Premier paragraphe.', 'Deuxième paragraphe.'], $row->data['paragraphs']);
        $old = 'editorial/'.basename($row->data['photo']);
        Storage::disk('public')->assertExists($old);
        $this->assertTrue($row->fresh()->is_published);
        $this->assertSame('novembre 2026', $row->fresh()->data['month']);
        $this->get('/actualites')->assertInertia(fn (Assert $p) => $p->has('clubNews', 7));
        $this->put('/admin/actualites/'.$row->id, $this->news(['is_published' => true, 'photo' => UploadedFile::fake()->createWithContent('nouvelle.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/l9sAAAAASUVORK5CYII='))]))->assertSessionHasNoErrors()->assertRedirect();
        Storage::disk('public')->assertMissing($old);
        $this->get('/actualites')->assertInertia(fn (Assert $p) => $p->has('clubNews', 7));
        $new = 'editorial/'.basename($row->fresh()->data['photo']);
        $this->delete('/admin/actualites/'.$row->id)->assertRedirect();
        Storage::disk('public')->assertMissing($new);
        $this->assertDatabaseMissing('club_contents', ['id' => $row->id]);
    }

    public function test_sponsor_edits_preserve_original_logo_and_visual_identity(): void
    {
        $this->actingAs($this->admin());
        $row = ClubContent::where('kind', 'sponsors')->firstOrFail();
        $data = $row->data;
        $data['specialties'] = implode("\n", $data['specialties']);
        $data['description'] = 'Présentation modifiée.';
        unset($data['logo'],$data['photo']);
        $this->put('/admin/sponsors/'.$row->id, array_merge($data, ['is_published' => true, 'sort_order' => 0]))->assertSessionHasNoErrors()->assertRedirect();
        $this->assertSame('/images/sponsors/le-plan-b.png', $row->fresh()->data['logo']);
        $this->assertSame('planb', $row->fresh()->data['theme']);
        $this->get('/sponsors')->assertInertia(fn (Assert $p) => $p->where('sponsors.0.description', 'Présentation modifiée.'));
        $this->put('/admin/actualites/'.$row->id, $this->news())->assertNotFound();
        $this->delete('/admin/actualites/'.$row->id)->assertNotFound();
    }

    public function test_contacts_and_social_changes_reach_public_pages(): void
    {
        $this->actingAs($this->admin());
        $row = ClubContent::where('kind', 'contacts')->firstOrFail();
        $this->put('/admin/contacts/'.$row->id, ['address' => "Stade du club\n88500 Hymont", 'entries' => [['name' => 'Contact test', 'phone' => '06 00 00 00 01'], ['name' => 'Autre contact', 'phone' => '06 00 00 00 02'], ['name' => 'Troisième contact', 'phone' => '06 00 00 00 03']]])->assertSessionHasNoErrors()->assertRedirect();
        $this->get('/contact')->assertInertia(fn (Assert $p) => $p->has('details.entries', 3)->where('details.entries.0.phone', '06 00 00 00 01'));
        $this->put('/admin/contacts/'.$row->id, ['address' => 'Stade', 'entries' => '[]'])->assertSessionHasNoErrors();
        $this->get('/contact')->assertInertia(fn (Assert $p) => $p->has('details.entries', 0)->missing('details.contact1_phone'));
        $row = ClubContent::where('kind', 'social')->firstOrFail();
        $this->put('/admin/reseaux/'.$row->id, ['entries' => [['name' => 'TikTok', 'account' => '@fchymont', 'url' => 'https://www.tiktok.com/@fchymont']]])->assertSessionHasNoErrors()->assertRedirect();
        $this->get('/reseaux')->assertInertia(fn (Assert $p) => $p->has('networks', 1)->where('networks.0.name', 'TikTok')->where('networks.0.href', 'https://www.tiktok.com/@fchymont'));
        $this->put('/admin/reseaux/'.$row->id, ['entries' => '[]'])->assertSessionHasNoErrors();
        $this->get('/reseaux')->assertInertia(fn (Assert $p) => $p->has('networks', 0));
    }

    public function test_unsafe_links_and_non_images_are_rejected(): void
    {
        $this->actingAs($this->admin());
        $row = ClubContent::where('kind', 'social')->firstOrFail();
        $this->put('/admin/reseaux/'.$row->id, ['entries' => [['name' => 'Test', 'url' => 'javascript:alert(1)']]])->assertSessionHasErrors('entries.0.url');
        $this->post('/admin/actualites', $this->news(['photo' => UploadedFile::fake()->create('code.php', 2, 'application/x-php')]))->assertSessionHasErrors('photo');
    }

    public function test_drag_order_is_shared_with_public_pages_and_invalid_lists_are_rejected(): void
    {
        $this->actingAs($this->admin());
        foreach (['news' => 'actualites', 'sponsors' => 'sponsors'] as $kind => $path) {
            $ids = ClubContent::where('kind', $kind)->orderBy('sort_order')->pluck('id')->reverse()->values()->all();
            $this->patch('/admin/'.$path.'/ordre', ['ids' => $ids])->assertSessionHasNoErrors();
            $this->assertSame($ids, ClubContent::where('kind', $kind)->orderBy('sort_order')->pluck('id')->all());
            $this->get('/'.$path)->assertInertia(fn (Assert $p) => $p->where(($kind === 'news' ? 'clubNews' : 'sponsors').'.0.id', (string) $ids[0]));
            $this->patch('/admin/'.$path.'/ordre', ['ids' => [$ids[0], $ids[0]]])->assertSessionHasErrors('ids.0');
            $this->patch('/admin/'.$path.'/ordre', ['ids' => array_slice($ids, 1)])->assertSessionHasErrors('ids');
            $foreign = ClubContent::where('kind', 'contacts')->firstOrFail()->id;
            $this->patch('/admin/'.$path.'/ordre', ['ids' => [$foreign, ...array_slice($ids, 1)]])->assertSessionHasErrors('ids');
            $this->assertSame($ids, ClubContent::where('kind', $kind)->orderBy('sort_order')->pluck('id')->all());
        }
        $this->actingAs(User::factory()->create());
        $this->patch('/admin/actualites/ordre', ['ids' => [1]])->assertForbidden();
    }

    public function test_new_sponsor_needs_only_the_simplified_fields_and_keeps_automatic_identity(): void
    {
        Storage::fake('public');
        $this->actingAs($this->admin());
        $this->post('/admin/sponsors', ['name' => 'Partenaire de test', 'category' => 'Activité', 'title' => 'Accroche', 'description' => 'Présentation', 'logo' => UploadedFile::fake()->createWithContent('logo.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/l9sAAAAASUVORK5CYII='))])->assertSessionHasNoErrors();
        $sponsor = ClubContent::where('kind', 'sponsors')->whereNull('source_key')->firstOrFail();
        $this->assertTrue($sponsor->is_published);
        $this->assertSame('neutral', $sponsor->data['theme']);
        $this->assertSame([], $sponsor->data['specialties']);
    }

    public function test_simplified_forms_and_legacy_coordinates_are_preserved(): void
    {
        $this->actingAs($this->admin());
        $this->get('/admin/actualites')->assertInertia(fn (Assert $p) => $p->has('fields', 5)->where('fields.3.type', 'date'));
        $this->get('/admin/sponsors')->assertInertia(fn (Assert $p) => $p->has('fields', 9));
        $this->get('/admin/contacts')->assertInertia(fn (Assert $p) => $p->has('items.0.data.entries', 2)->where('items.0.data.entries.0.name', 'M. Ribeiro'));
        $this->get('/admin/reseaux')->assertInertia(fn (Assert $p) => $p->has('items.0.data.entries', 2));
        $this->post('/admin/actualites', $this->news(['date' => '2026-02-30']))->assertSessionHasErrors('date');
        $this->post('/admin/actualites', $this->news(['is_published' => false, 'sort_order' => 9999]))->assertSessionHasNoErrors();
        $entry = ClubContent::whereNull('source_key')->firstOrFail();
        $this->assertTrue($entry->is_published);
        $this->assertNotSame(9999, $entry->sort_order);
    }

    public function test_admin_login_redirects_to_admin_and_intended_route_is_preserved(): void
    {
        $user = $this->admin();
        $user->update(['password' => Hash::make('test-password-only')]);
        $this->post('/login', ['email' => $user->email, 'password' => 'test-password-only'])->assertRedirect('/admin');
    }

    public function test_create_admin_command_refuses_to_overwrite_existing_users(): void
    {
        $this->artisan('club:create-admin', ['email' => 'technical@example.test'])->assertSuccessful();
        $user = User::where('email', 'technical@example.test')->firstOrFail();
        $hash = $user->password;
        $this->assertTrue($user->is_admin);
        $this->artisan('club:create-admin', ['email' => 'technical@example.test'])->assertFailed();
        $this->assertSame($hash, $user->fresh()->password);
    }
}
