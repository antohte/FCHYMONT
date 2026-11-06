<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use Inertia\Inertia;
use Inertia\Response;

class CalendarController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Calendar', [
            'fixtures' => Fixture::where('is_published', true)->orderBy('match_date')->orderBy('kickoff_time')->orderBy('id')->get()->map->publicData(),
            'today' => now('Europe/Paris')->format('Y-m-d'), 'currentTime' => now('Europe/Paris')->format('H:i')]);
    }
}
