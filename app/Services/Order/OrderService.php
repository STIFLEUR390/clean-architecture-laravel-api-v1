<?php

namespace App\Services\Order;

use App\Models\Order;
use LaravelEasyRepository\BaseService;

interface OrderService extends BaseService
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
     */
    public function getOrderPaymentStatus(string $id);

    /**
     * Generer la facture d'une commande
     */
    public function GenerateInvoice(string $id): string;

    /**
     * Verifier le d'une commande
     */
    public function verifyPaiement(string $id): Order;

    /**
     * Annuler un paiement
     */
    public function cancelOrderPayment(string $transaction_id): bool;
}
