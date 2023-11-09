<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self SENT()
 * @method static self FAILED()
 * @method static self COMPLETE()
 */
final class TransfertStatus extends Enum
{
    protected static function labels(): array
    {
        return [
            'sent' => 'L\'ordre de transfert a été remis à l\'opérateur',
            'failed' => 'le transfert a échoué',
            'complete' => 'Le transfert a été effectué',
        ];
    }

    protected static function values(): array
    {
        return [
            'sent' => 'transfer.sent',
            'failed' => 'transfer.failed',
            'complete' => 'transfer.complete',
        ];
    }
}
