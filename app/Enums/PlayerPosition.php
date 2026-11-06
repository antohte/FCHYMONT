<?php

namespace App\Enums;

enum PlayerPosition: string
{
    case Goalkeeper = 'goalkeeper';
    case Defender = 'defender';
    case Midfielder = 'midfielder';
    case Forward = 'forward';

    public function label(): string
    {
        return match ($this) {
            self::Goalkeeper => 'Gardiens',
            self::Defender => 'Défenseurs',
            self::Midfielder => 'Milieux',
            self::Forward => 'Attaquants',
        };
    }

    public function abbreviation(): string
    {
        return match ($this) {
            self::Goalkeeper => 'G',
            self::Defender => 'DÉF',
            self::Midfielder => 'MIL',
            self::Forward => 'ATT',
        };
    }
}
