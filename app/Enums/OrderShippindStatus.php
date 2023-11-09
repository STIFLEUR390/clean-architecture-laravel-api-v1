<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self PENDING()
 * @method static self BEINGVERIFIED()
 * @method static self INPREPARATION()
 * @method static self INTRANSIT()
 * @method static self DELIVERED()
 * @method static self CANCELED()
 * @method static self RETURNED()
 * @method static self REIMBURSED()
 */
final class OrderShippindStatus extends Enum
{
    protected static function labels(): array
    {
        return [
            'pending' => 'La commande a été créée',
            'beingverified' => 'la commande est en cours de vérification',
            'inpreparation' => 'La commande est en cours de préparation pour l\'expédition',
            'intransit' => 'La commande a été expédiée et est en cours de livraison vers l\'adresse de livraison spécifiée',
            'delivered' => 'La commande a été livrée',
            'canceled' => 'La commande a été annulée',
            'returned' => 'La commande a été retournée',
            'reimbursed' => 'La commande a été annulée et le remboursement a été effectué au client',
        ];
    }

    protected static function values(): array
    {
        return [
            'pending' => 'pending',
            'beingverified' => 'being_verified',
            'inpreparation' => 'in_preparation',
            'intransit' => 'in_transit',
            'delivered' => 'delivered',
            'canceled' => 'canceled',
            'returned' => 'returned',
            'reimbursed' => 'reimbursed',
        ];
    }
}
