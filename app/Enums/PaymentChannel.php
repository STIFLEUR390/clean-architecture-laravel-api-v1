<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self MTN()
 * @method static self ORANGE()
 * @method static self MOBILE()
 * @method static self PAYPAL()
 * @method static self CARD()
 */
final class PaymentChannel extends Enum
{
    protected static function labels(): array
    {
        return [
            'mtn' => 'MTN Mobile Money Cameroun',
            'cm.orange' => 'Orange Money Cameroun',
            'mobile' => 'Orange Money ou MTN Mobile Money Cameroon',
            'paypal' => 'PayPal',
            'card' => 'Visa, Mastercard, Amex, etc',
        ];
    }

    protected static function values(): array
    {
        return [
            'mtn' => 'cm.mtn',
            'cm.orange' => 'cm.orange',
            'mobile' => 'cm.mobile',
            'paypal' => 'paypal',
            'card' => 'Card',
        ];
    }
}
