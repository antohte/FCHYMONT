<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('club_contents', function (Blueprint $table) {
            $table->id();
            $table->string('kind');
            $table->string('source_key')->nullable()->unique();
            $table->json('data');
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index(['kind', 'is_published', 'sort_order']);
        });
        $source = json_decode(file_get_contents(database_path('data/editorial.json')), true, 512, JSON_THROW_ON_ERROR);
        foreach ($source as $kind => $items) {
            foreach ($items as $i => $data) {
                $key = $data['id'];
                unset($data['id']);
                if ($kind === 'sponsors') {
                    $data['theme'] = $key;
                }
                DB::table('club_contents')->insert(['kind' => $kind, 'source_key' => "$kind:$key", 'data' => json_encode($data, JSON_UNESCAPED_UNICODE), 'is_published' => true, 'sort_order' => $i, 'created_at' => now(), 'updated_at' => now()]);
            }
        }
        foreach ([
            'contacts' => ['address' => "Stade Municipal d’Hymont\n88500 Hymont\nVosges, Grand Est", 'contact1_name' => 'M. Ribeiro', 'contact1_phone' => '06 38 71 21 84', 'contact2_name' => 'M. Mangin', 'contact2_phone' => '06 14 94 11 24'],
            'social' => ['instagram_account' => '@footballclubhymont', 'instagram_url' => 'https://www.instagram.com/footballclubhymont/', 'facebook_account' => 'FC Hymont', 'facebook_url' => 'https://www.facebook.com/people/FC-Hymont/61590803726598/'],
        ] as $kind => $data) {
            DB::table('club_contents')->insert(['kind' => $kind, 'source_key' => $kind, 'data' => json_encode($data, JSON_UNESCAPED_UNICODE), 'is_published' => true, 'sort_order' => 0, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('club_contents');
    }
};
