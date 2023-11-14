<?php

namespace App\Repositories\Order;

use App\Models\Order;
use LaravelEasyRepository\Repository;

interface OrderRepository extends Repository
{
    /**
     * Mettre à jour le status d'une commande
     */
    public function updateOrderStatus(string $id, string $status): bool;

    /**
     * Mettre à jour le status du paiement d'une commande
     */
    public function updateOrderPaymentStatus(string $id, string $status): bool;

    /**
     * Récuperer le status d'une commande
     *
     * @param  string  $orderId
     */
    public function getOrderPaymentStatus(string $id);

    /**
     * Récupérer une commande avec ces relations
     */
    public function findOrFailWithRelationship(string $id, array $relationships): Order;

    /**
     * Enregistrer les paiement d'une commande
     */
    public function saveOrderPayment(string $id, array $data): bool;
}
