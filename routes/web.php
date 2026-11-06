<?php

use App\Http\Controllers\Admin\CalendarController as AdminCalendarController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\PlayersController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClubPagesController;
use App\Http\Controllers\SelectionController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('equipe', TeamController::class)->name('team');
Route::get('sponsors', [ClubPagesController::class, 'sponsors'])->name('sponsors');
Route::get('reseaux', [ClubPagesController::class, 'social'])->name('social');

Route::get('actualites', [ClubPagesController::class, 'news'])->name('news');

Route::get('convocation', SelectionController::class)->name('selection');

Route::get('club', fn () => Inertia::render('ClubPlaceholder', [
    'title' => 'Le club',
    'active' => 'club',
]))->name('club');

Route::get('contact', [ClubPagesController::class, 'contact'])->name('contact');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('calendrier', CalendarController::class)->name('calendar');
Route::middleware(['auth', 'can:manage-calendar'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('joueurs', [PlayersController::class, 'index'])->name('players.index');
    Route::post('joueurs', [PlayersController::class, 'store'])->name('players.store');
    Route::put('joueurs/{player}', [PlayersController::class, 'update'])->name('players.update');
    Route::delete('joueurs/{player}', [PlayersController::class, 'destroy'])->name('players.destroy');
    Route::get('convocation', [App\Http\Controllers\Admin\SelectionController::class, 'index'])->name('selection.index');
    Route::put('convocation', [App\Http\Controllers\Admin\SelectionController::class, 'save'])->name('selection.save');
    Route::delete('convocation', [App\Http\Controllers\Admin\SelectionController::class, 'unpublish'])->name('selection.unpublish');
    Route::get('calendrier', [AdminCalendarController::class, 'index'])->name('calendar.index');
    Route::post('calendrier', [AdminCalendarController::class, 'store'])->name('calendar.store');
    Route::put('calendrier/{fixture}', [AdminCalendarController::class, 'update'])->name('calendar.update');
    Route::delete('calendrier/{fixture}', [AdminCalendarController::class, 'destroy'])->name('calendar.destroy');
});

Route::middleware(['auth', 'can:manage-calendar'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => Inertia::render('Admin/Index'))->name('index');
    foreach (['news' => 'actualites', 'sponsors' => 'sponsors', 'contacts' => 'contacts', 'social' => 'reseaux'] as $kind => $path) {
        Route::get($path, [ContentController::class, 'index'])->defaults('kind', $kind)->name("$kind.index");
        Route::post($path, [ContentController::class, 'store'])->defaults('kind', $kind)->name("$kind.store");
        Route::patch($path.'/ordre', [ContentController::class, 'reorder'])->defaults('kind', $kind)->name("$kind.reorder");
        Route::put($path.'/{content}', [ContentController::class, 'update'])->defaults('kind', $kind)->name("$kind.update");
        Route::delete($path.'/{content}', [ContentController::class, 'destroy'])->defaults('kind', $kind)->name("$kind.destroy");
    }
});
