<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FixtureRequest;
use App\Models\Fixture;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CalendarController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Calendar', [
            'fixtures' => Fixture::orderByDesc('match_date')->orderByDesc('id')->get()->map(fn (Fixture $fixture) => [...$fixture->publicData(), 'published' => $fixture->is_published]),
            'notice' => $request->session()->get('calendar_notice')]);
    }

    public function store(FixtureRequest $request): RedirectResponse
    {
        Fixture::create($request->validated());

        return to_route('admin.calendar.index')->with('calendar_notice', 'Le match a été ajouté.');
    }

    public function update(FixtureRequest $request, Fixture $fixture): RedirectResponse
    {
        $fixture->update($request->validated());

        return to_route('admin.calendar.index')->with('calendar_notice', 'Le match a été mis à jour.');
    }

    public function destroy(Fixture $fixture): RedirectResponse
    {
        $fixture->delete();

        return to_route('admin.calendar.index')->with('calendar_notice', 'Le match a été supprimé.');
    }
}
