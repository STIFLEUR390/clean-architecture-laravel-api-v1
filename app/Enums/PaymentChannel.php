<?php

namespace App\Enums;

enum PaymentChannel: string
{
    case MTN = 'cm.mtn';
    case ORANGE = 'cm.orange';
    case MOBILE = 'cm.mobile';
    case PAYPAL = 'paypal';
    case CARD = 'Card';

    public function label(): string
    {
        return match ($this) {
            self::MTN => 'MTN Mobile Money',
            self::ORANGE => 'Orange Money',
            self::MOBILE => 'Orange Money ou MTN Mobile Money Cameroon',
            self::PAYPAL => 'PayPal',
            self::CARD => 'Visa, Mastercard, Amex, etc',
        };
    }
}
