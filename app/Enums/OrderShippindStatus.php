<?php

namespace App\Enums;

enum OrderShippindStatus: string
{
    case PENDING = 'pending';
    case BEINGVERIFIED = 'being_verified';
    case INPREPARATION = 'in_preparation';
    case INTRANSIT = 'in_transit';
    case DELIVERED = 'delivered';
    case CANCELED = 'canceled';
    case RETURNED = 'returned';
    case REIMBURSED = 'reimbursed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'La commande a été créée',
            self::BEINGVERIFIED => 'la commande est en cours de vérification',
            self::INPREPARATION => 'La commande est en cours de préparation pour l\'expédition',
            self::INTRANSIT => 'La commande a été expédiée et est en cours de livraison vers l\'adresse de livraison spécifiée',
            self::DELIVERED => 'La commande a été livrée',
            self::CANCELED => 'La commande a été annulée',
            self::RETURNED => 'La commande a été retournée',
            self::REIMBURSED => 'La commande a été annulée et le remboursement a été effectué au client',
        };
    }
}
