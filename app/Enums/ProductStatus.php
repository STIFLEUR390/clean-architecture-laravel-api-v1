<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self INSTOCK()
 * @method static self OUTSTOCK()
 */
final class ProductStatus extends Enum
{
    protected static function labels(): array
    {
        return [
            'instock' => 'En stock',
            'outstock' => 'En rupture de stock',
        ];
    }

    protected static function values(): array
    {
        return [
            'instock' => 1,
            'outstock' => 0,
        ];
    }
}
