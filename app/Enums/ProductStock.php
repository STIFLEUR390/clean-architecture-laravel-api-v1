<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self INSTOCK()
 * @method static self OUTSTOCK()
 * @method static self OUTSTOCK()
 */
final class ProductStock extends Enum
{
    protected static function labels(): array
    {
        return [
            'publish' => 'Publier',
            'scheduled' => 'Programmé',
            'inactive' => 'Inactif',
        ];
    }

    protected static function values(): array
    {
        return [
            'publish' => 'publish',
            'scheduled' => 'scheduled',
            'inactive' => 'inactive',
        ];
    }
}
