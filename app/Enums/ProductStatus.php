<?php

namespace App\Enums;

enum ProductStatus: string
{
    case PUBLISH = 'publish';
    case SCHEDULED = 'scheduled';
    case INACTIVE = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::PUBLISH => 'Publier',
            self::SCHEDULED => 'Programmé',
            self::INACTIVE => 'Inactif',
        };
    }
}
