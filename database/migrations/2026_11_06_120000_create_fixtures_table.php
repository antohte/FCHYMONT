<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->string('opponent_name', 120);
            $table->date('match_date')->index();
            $table->string('kickoff_time', 5)->nullable();
            $table->string('competition', 120);
            $table->string('venue', 160)->nullable();
            $table->boolean('is_home')->default(true);
            $table->string('status')->default('scheduled');
            $table->unsignedTinyInteger('club_score')->nullable();
            $table->unsignedTinyInteger('opponent_score')->nullable();
            $table->boolean('is_published')->default(false)->index();
            $table->timestamps();
        });
        Schema::table('users', fn (Blueprint $table) => $table->boolean('is_admin')->default(false));
    }

    public function down(): void
    {
        Schema::dropIfExists('fixtures');
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('is_admin'));
    }
};
