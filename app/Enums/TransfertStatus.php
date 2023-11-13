<?php

namespace App\Enums;

enum TransfertStatus: string
{
    case SENT = 'transfer.sent';
    case FAILED = 'transfer.failed';
    case COMPLETE = 'transfer.complete';

    public function label(): string
    {
        return match ($this) {
            self::SENT => 'L\'ordre de transfert a été remis à l\'opérateur',
            self::FAILED => 'Le transfert a échoué',
            self::COMPLETE => 'Le transfert a été effectué',
        };
    }
}
