<?php

namespace App\Enums;

enum ProductStock: int
{
    case INSTOCK = 1;
    case OUTSTOCK = 0;

    public function label(): string
    {
        return match ($this) {
            self::INSTOCK => 'En stock',
            self::OUTSTOCK => 'En rupture de stock',
        };
    }
}
