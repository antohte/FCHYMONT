<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClubContent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ContentController extends Controller
{
    public static function definitions(string $kind): array
    {
        $text = fn ($key, $label, $required = false, $type = 'text') => compact('key', 'label', 'required', 'type');

        return match ($kind) {
            'news' => [$text('title', 'Titre', true), $text('excerpt', 'Résumé', true, 'textarea'), $text('paragraphs', 'Contenu de l’article', true, 'textarea'), $text('date', 'Date', true, 'date'), $text('photo', 'Photo', false, 'file')],
            'sponsors' => [$text('name', 'Nom', true), $text('category', 'Activité', true), $text('title', 'Accroche', true), $text('description', 'Présentation', true, 'textarea'), $text('website', 'Site internet', false, 'url'), $text('address', 'Adresse'), $text('phone', 'Téléphone', false, 'tel'), $text('logo', 'Logo', false, 'file'), $text('photo', 'Photo de bannière', false, 'file')],
            'contacts' => [$text('address', 'Adresse du stade', true, 'textarea'), $text('entries', 'Contacts', false, 'collection')],
            'social' => [$text('entries', 'Réseaux', false, 'collection')],
            default => abort(404),
        };
    }

    public function index(Request $request, string $kind)
    {
        return Inertia::render('Admin/Content', ['kind' => $kind, 'fields' => self::definitions($kind), 'items' => ClubContent::where('kind', $kind)->orderBy('sort_order')->orderByDesc('id')->get()->map(fn ($row) => ['id' => $row->id, 'data' => $row->editorData(), 'is_published' => $row->is_published, 'sort_order' => $row->sort_order]), 'notice' => $request->session()->get('notice')]);
    }

    public function store(Request $request, string $kind)
    {
        abort_if(in_array($kind, ['contacts', 'social']) && ClubContent::where('kind', $kind)->exists(), 405);

        return $this->persist($request, $kind, new ClubContent(['kind' => $kind]));
    }

    public function update(Request $request, ClubContent $content, string $kind)
    {
        abort_unless($content->kind === $kind, 404);

        return $this->persist($request, $kind, $content);
    }

    private function persist(Request $request, string $kind, ClubContent $content)
    {
        if (in_array($kind, ['contacts', 'social']) && is_string($request->input('entries'))) {
            $request->validate(['entries' => ['json']]);
            $request->merge(['entries' => json_decode($request->input('entries'), true)]);
        }
        $rules = [];
        foreach (self::definitions($kind) as $field) {
            $key = $field['key'];
            if ($field['type'] === 'collection') {
                $rules[$key] = ['present', 'array', 'max:50'];
                $rules[$key.'.*'] = ['array:'.($kind === 'contacts' ? 'name,phone' : 'name,account,url')];
                $rules[$key.'.*.name'] = ['required', 'string', 'max:100'];
                if ($kind === 'contacts') {
                    $rules[$key.'.*.phone'] = ['required', 'string', 'max:100', 'regex:/^[+0-9().\s-]+$/'];
                } else {
                    $rules[$key.'.*.account'] = ['nullable', 'string', 'max:200'];
                    $rules[$key.'.*.url'] = ['required', 'url:http,https', 'max:500'];
                }
            } elseif ($field['type'] === 'date') {
                $rules[$key] = ['required', 'date_format:Y-m-d'];
            } elseif ($field['type'] === 'file') {
                $rules[$key] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096', 'dimensions:max_width=6000,max_height=6000'];
                $rules['remove_'.$key] = ['sometimes', 'boolean'];
            } else {
                $rules[$key] = [$field['required'] ? 'required' : 'nullable', 'string', 'max:'.($field['type'] === 'textarea' ? 20000 : 500)];
            }
        }
        foreach (['website', 'instagram_url', 'facebook_url'] as $key) {
            if (isset($rules[$key])) {
                $rules[$key][] = 'url:http,https';
            }
        }
        foreach (['contact1_phone', 'contact2_phone', 'phone'] as $key) {
            if (isset($rules[$key])) {
                $rules[$key][] = 'regex:/^[+0-9().\s-]*$/';
            }
        }
        if ($kind === 'sponsors') {
            if (empty($content->data['logo'])) {
                $rules['logo'][0] = 'required';
            }
            if ($request->boolean('remove_logo') && ! $request->hasFile('logo')) {
                $rules['logo'][0] = 'required';
            }
        }
        $values = $request->validate($rules, ['required' => 'Ce champ est obligatoire.', 'url' => 'Saisissez une adresse HTTP ou HTTPS valide.', 'image' => 'Choisissez une image valide.', 'mimes' => 'Formats acceptés : JPEG, PNG et WebP.', 'max.file' => 'L’image ne doit pas dépasser 4 Mo.', 'in' => 'Choisissez une identité proposée.', 'regex' => 'Saisissez un numéro de téléphone valide.']);
        $data = $content->data ?? [];
        if ($kind === 'contacts') {
            foreach (['contact1_name', 'contact1_phone', 'contact2_name', 'contact2_phone'] as $legacy) {
                unset($data[$legacy]);
            }
        } elseif ($kind === 'social') {
            foreach (['instagram_account', 'instagram_url', 'facebook_account', 'facebook_url'] as $legacy) {
                unset($data[$legacy]);
            }
        }
        if ($kind === 'sponsors') {
            $data['theme'] ??= 'neutral';
            $data['specialties'] ??= [];
        }
        $created = [];
        $obsolete = [];
        try {
            foreach (self::definitions($kind) as $field) {
                $key = $field['key'];
                if ($field['type'] === 'file') {
                    $old = $data[$key] ?? null;
                    if ($request->hasFile($key)) {
                        $path = $request->file($key)->store('editorial', 'public');
                        if (! $path) {
                            throw new \RuntimeException('Échec de l’enregistrement de l’image.');
                        }
                        $created[] = $path;
                        $data[$key] = Storage::disk('public')->url($path);
                    } elseif ($request->boolean('remove_'.$key)) {
                        $data[$key] = null;
                    }
                    if ($old && ($data[$key] ?? null) !== $old) {
                        $obsolete[] = $old;
                    }
                } elseif (in_array($key, ['paragraphs', 'specialties'])) {
                    $data[$key] = array_values(array_filter(array_map('trim', preg_split($key === 'paragraphs' ? '/\R\s*\R/' : '/\R/', $values[$key] ?? ''))));
                } else {
                    $data[$key] = $values[$key] ?? null;
                }
            }
            if ($kind === 'news') {
                $date = Carbon::createFromFormat('Y-m-d', $values['date']);
                $data['day'] = $date->format('d');
                $data['month'] = $date->locale('fr')->translatedFormat('F Y');
                $data['category'] ??= 'Club';
            }
            $content->fill(['data' => $data, 'is_published' => true, 'sort_order' => $content->exists ? $content->sort_order : ((int) ClubContent::where('kind', $kind)->max('sort_order') + 1)])->save();
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($created);
            throw $e;
        }
        foreach ($obsolete as $url) {
            $this->deleteUpload($url);
        }

        return back()->with('notice', 'Modifications enregistrées.');
    }

    public function reorder(Request $request, string $kind)
    {
        abort_unless(in_array($kind, ['news', 'sponsors']), 404);
        $values = $request->validate(['ids' => ['required', 'array', 'min:1'], 'ids.*' => ['required', 'integer', 'distinct']]);
        DB::transaction(function () use ($values, $kind) {
            $existing = ClubContent::where('kind', $kind)->lockForUpdate()->pluck('id')->all();
            $ids = array_map('intval', $values['ids']);
            sort($existing);
            $sorted = $ids;
            sort($sorted);
            if ($existing !== $sorted) {
                throw ValidationException::withMessages(['ids' => 'La liste a changé. Actualisez la page avant de réessayer.']);
            }
            foreach ($ids as $position => $id) {
                ClubContent::where('kind', $kind)->whereKey($id)->update(['sort_order' => $position]);
            }
        });

        return back()->with('notice', 'Ordre enregistré.');
    }

    public function destroy(ClubContent $content, string $kind)
    {
        self::definitions($kind);
        abort_unless($content->kind === $kind, 404);
        abort_if(in_array($kind, ['contacts', 'social']), 405);
        $data = $content->data;
        $content->delete();
        foreach (['logo', 'photo'] as $key) {
            if (! empty($data[$key])) {
                $this->deleteUpload($data[$key]);
            }
        }

        return back()->with('notice', 'Élément supprimé.');
    }

    private function deleteUpload(string $url): void
    {
        $prefix = Storage::disk('public')->url('editorial/');
        if (str_starts_with($url, $prefix)) {
            Storage::disk('public')->delete('editorial/'.basename($url));
        }
    }
}
