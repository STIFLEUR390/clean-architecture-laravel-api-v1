<?php

namespace App\Enums;

enum AddressCivility: string
{
    case M = 'M.';
    case Mme = 'Mme';
    case Mlle = 'Mlle';

    public function label(): string
    {
        return match ($this) {
            self::M => 'Monsieur',
            self::Mme => 'Madame',
            self::Mlle => 'Mademoiselle',
        };
    }
}
