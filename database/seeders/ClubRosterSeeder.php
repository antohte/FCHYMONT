<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClubRosterSeeder extends Seeder
{
    public function run(): void
    {
        // Noms abrégés, postes et numéros vérifiés sur le site public le 5 novembre 2026.
        $players = [
            ['Léo B', 'goalkeeper', 'Gardien de but', 1],
            ['Mateo F', 'defender', 'Latéral', 2],
            ['Lucas G', 'defender', 'Latéral', 2],
            ['Yanis R', 'defender', 'Latéral droit', 2],
            ['Valentin B', 'defender', 'Latéral', 3],
            ['Marwan L', 'defender', 'Latéral', 3],
            ['Gianni C', 'defender', 'Défenseur central', 4],
            ['Alexis R', 'defender', 'Défenseur central', 4],
            ['Arthur P', 'defender', 'Défenseur central', 5],
            ['Mathis P', 'defender', 'Défenseur', 5],
            ['Hugo G', 'defender', 'Défenseur central', 5],
            ['Angelin L', 'midfielder', 'Milieu', 6],
            ['Killian M', 'midfielder', 'Milieu central', 8],
            ['Sinan S', 'midfielder', 'Milieu central', 8],
            ['Lucas R', 'midfielder', 'Milieu central', 8],
            ['Bilal U', 'midfielder', 'Milieu central', 8],
            ['Anas C', 'midfielder', 'Milieu offensif', 10],
            ['Bryan J', 'midfielder', 'Milieu offensif', 10],
            ['Kevin R', 'forward', 'Avant-centre', 7],
            ['Anton S', 'forward', 'Ailier', 7],
            ['Theo R', 'forward', 'Ailier droit', 9],
            ['Sami S', 'forward', 'Avant-centre', 9],
            ['Sem T', 'forward', 'Avant-centre', 9],
            ['Cédric G', 'forward', 'Ailier', 11],
            ['Kevin M', 'forward', 'Ailier', 11],
            ['Theo M', 'forward', 'Ailier', 13],
        ];

        foreach ($players as [$name, $position, $label, $number]) {
            Player::firstOrCreate(['source_key' => 'hymont-'.Str::slug($name)], [
                'display_name' => $name,
                'position' => $position,
                'position_label' => $label,
                'number' => $number,
                'is_published' => true,
            ]);
        }
    }
}
