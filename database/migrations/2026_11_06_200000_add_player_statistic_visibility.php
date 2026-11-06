<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->boolean('show_goals')->default(false);
            $table->boolean('show_saves')->default(false);
        });
        // Préserver les statistiques déjà rendues publiques par les anciens réglages.
        $settings = DB::table('club_settings')->where('id', 1)->first();
        if ($settings?->show_goals) {
            DB::table('players')->where('position', '!=', 'goalkeeper')->update(['show_goals' => true]);
        }
        if ($settings?->show_saves) {
            DB::table('players')->where('position', 'goalkeeper')->update(['show_saves' => true]);
        }
    }

    public function down(): void
    {
        Schema::table('players', fn (Blueprint $table) => $table->dropColumn(['show_goals', 'show_saves']));
    }
};
