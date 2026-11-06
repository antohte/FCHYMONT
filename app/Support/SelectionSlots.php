<?php

namespace App\Support;

class SelectionSlots
{
    public static function find(array $entry): ?array
    {
        foreach (config('selection.slots') as $slot) {
            if (isset($entry['x'], $entry['y']) && (float) $entry['x'] === (float) $slot['x'] && (float) $entry['y'] === (float) $slot['y']) {
                return $slot;
            }
        }

        return null;
    }

    // Recalage en mémoire des anciens placements libres, sans modifier les données enregistrées.
    public static function normalize(array $placements): array
    {
        $used = [];
        $assigned = [];
        foreach ($placements as $index => $entry) {
            $slot = self::find($entry);
            if (! ($entry['bench'] ?? false) && $slot && ! isset($used[$slot['id']])) {
                $assigned[$index] = $slot;
                $used[$slot['id']] = true;
            }
        }
        foreach ($placements as $index => &$entry) {
            if ($entry['bench'] ?? false) {
                $entry['x'] = $entry['y'] = null;

                continue;
            }
            $slot = $assigned[$index] ?? null;
            if (! $slot) {
                $free = array_values(array_filter(config('selection.slots'), fn ($candidate) => ! isset($used[$candidate['id']])));
                usort($free, fn ($a, $b) => (($a['x'] - ($entry['x'] ?? 50)) ** 2 + ($a['y'] - ($entry['y'] ?? 50)) ** 2) <=> (($b['x'] - ($entry['x'] ?? 50)) ** 2 + ($b['y'] - ($entry['y'] ?? 50)) ** 2));
                $slot = $free[0] ?? null;
            }
            if ($slot) {
                $used[$slot['id']] = true;
                $entry['x'] = $slot['x'];
                $entry['y'] = $slot['y'];
            } else {
                $entry['bench'] = true;
                $entry['x'] = $entry['y'] = null;
            }
        }
        unset($entry);

        return $placements;
    }
}
