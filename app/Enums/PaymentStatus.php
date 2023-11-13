<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case COMPLETE = 'payment.complete';
    case FAILED = 'payment.failed';
    case CANCELED = 'payment.canceled';
    case EXPIRED = 'payment.expired';
    case PENDING = 'pending';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::COMPLETE => 'La paiement à été fait',
            self::FAILED => 'Le paiement a échoué',
            self::CANCELED => 'Le paiement a été annulé',
            self::EXPIRED => 'Le délai de traitement du paiement a expiré',
        };
    }
}
