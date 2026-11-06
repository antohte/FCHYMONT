<?php

namespace Database\Seeders;

use App\Models\Fixture;
use Illuminate\Database\Seeder;

class ClubCalendarSeeder extends Seeder
{
    public function run(): void
    {
        $rows = json_decode(file_get_contents(database_path('data/fixtures-2026-2027.json')), true, flags: JSON_THROW_ON_ERROR);
        foreach ($rows as $row) {
            Fixture::firstOrCreate(['source_key' => $row['source_key']], $row);
        }
    }
}
