<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('club_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('show_goals')->default(false);
            $table->boolean('show_saves')->default(false);
        });
        DB::table('club_settings')->insert(['id' => 1, 'show_goals' => false, 'show_saves' => false]);
    }

    public function down(): void
    {
        Schema::dropIfExists('club_settings');
    }
};
