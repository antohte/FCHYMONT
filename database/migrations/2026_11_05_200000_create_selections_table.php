<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('selections', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('draft')->index();
            $table->json('placements');
            $table->boolean('show_goals')->default(false);
            $table->boolean('show_saves')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
        Schema::table('players', function (Blueprint $table) {
            $table->unsignedInteger('goals')->nullable();
            $table->unsignedInteger('saves')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('selections');
        Schema::table('players', fn (Blueprint $table) => $table->dropColumn(['goals', 'saves']));
    }
};
