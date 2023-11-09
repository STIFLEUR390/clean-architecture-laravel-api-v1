<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self COMPLETE()
 * @method static self FAILED()
 * @method static self CANCELED()
 * @method static self EXPIRED()
 */
final class OrderPaymentStatus extends Enum
{
    protected static function labels(): array
    {
        return [
            'complete' => 'La paiement à été fait',
            'failed' => 'Le paiement a échoué',
            'canceled' => 'Le paiement a été annulé',
            'expired' => 'Le délai de traitement du paiement a expiré',
        ];
    }

    protected static function values(): array
    {
        return [
            'complete' => 'payment.complete',
            'failed' => 'payment.failed',
            'canceled' => 'payment.canceled',
            'expired' => 'payment.expired',
        ];
    }
}
