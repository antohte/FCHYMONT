<?php

namespace App\Http\Controllers;

use App\Models\ClubContent;
use Inertia\Inertia;

class ClubPagesController extends Controller
{
    public function news()
    {
        return Inertia::render('News', ['clubNews' => $this->items('news')]);
    }

    public function sponsors()
    {
        return Inertia::render('Sponsors', ['sponsors' => $this->items('sponsors')]);
    }

    public function contact()
    {
        return Inertia::render('Contact', ['details' => ClubContent::where('kind', 'contacts')->where('is_published', true)->first()?->editorData()]);
    }

    public function social()
    {
        $data = ClubContent::where('kind', 'social')->where('is_published', true)->first()?->editorData() ?? [];
        $networks = [];
        foreach ($data['entries'] ?? [] as $index => $entry) {
            $name = $entry['name'];
            $key = strtolower($name);
            $networks[] = ['network' => in_array($key, ['instagram', 'facebook']) ? $key : 'other-'.$index, 'name' => $name, 'account' => $entry['account'] ?? '', 'href' => $entry['url']];
        }

        return Inertia::render('Social', compact('networks'));
    }

    private function items(string $kind)
    {
        return ClubContent::where('kind', $kind)->where('is_published', true)->orderBy('sort_order')->orderByDesc('id')->get()->map(fn ($row) => $row->publicData());
    }
}
