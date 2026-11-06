<?php

return [
    'slots' => [
        ['id' => 'place-1', 'label' => 'Place 1 · pointe', 'x' => 50, 'y' => 16],
        ['id' => 'place-2', 'label' => 'Place 2 · avant gauche', 'x' => 19, 'y' => 34],
        ['id' => 'place-3', 'label' => 'Place 3 · avant centre', 'x' => 50, 'y' => 38],
        ['id' => 'place-4', 'label' => 'Place 4 · avant droite', 'x' => 81, 'y' => 34],
        ['id' => 'place-5', 'label' => 'Place 5 · milieu gauche', 'x' => 34, 'y' => 56],
        ['id' => 'place-6', 'label' => 'Place 6 · milieu droit', 'x' => 66, 'y' => 56],
        ['id' => 'place-7', 'label' => 'Place 7 · arrière gauche', 'x' => 15, 'y' => 74],
        ['id' => 'place-8', 'label' => 'Place 8 · arrière centre gauche', 'x' => 38, 'y' => 75],
        ['id' => 'place-9', 'label' => 'Place 9 · arrière centre droit', 'x' => 62, 'y' => 75],
        ['id' => 'place-10', 'label' => 'Place 10 · arrière droite', 'x' => 85, 'y' => 74],
        ['id' => 'place-11', 'label' => 'Place 11 · devant le but', 'x' => 50, 'y' => 94],
    ],
    // Aperçu local uniquement, jamais présenté comme une convocation officielle.
    'preview' => env('SELECTION_PREVIEW', env('APP_ENV') === 'local'),
    // Placement illustratif ; les identités proviennent uniquement de l'effectif vérifié.
    'preview_placements' => [
        ['key' => 'hymont-kevin-r', 'x' => 50, 'y' => 16],
        ['key' => 'hymont-kevin-m', 'x' => 19, 'y' => 34],
        ['key' => 'hymont-anas-c', 'x' => 50, 'y' => 38],
        ['key' => 'hymont-theo-m', 'x' => 81, 'y' => 34],
        ['key' => 'hymont-angelin-l', 'x' => 34, 'y' => 56],
        ['key' => 'hymont-killian-m', 'x' => 66, 'y' => 56],
        ['key' => 'hymont-lucas-g', 'x' => 15, 'y' => 74],
        ['key' => 'hymont-gianni-c', 'x' => 38, 'y' => 75],
        ['key' => 'hymont-mathis-p', 'x' => 62, 'y' => 75],
        ['key' => 'hymont-yanis-r', 'x' => 85, 'y' => 74],
        ['key' => 'hymont-leo-b', 'x' => 50, 'y' => 94],
        ['key' => 'hymont-theo-r', 'bench' => true],
        ['key' => 'hymont-lucas-r', 'bench' => true],
        ['key' => 'hymont-anton-s', 'bench' => true],
    ],
];
