<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $order = Order::orderBy('id', 'desc')->first();
        if (is_null($order)) {
            $ref = 'PO1000';
        } else {
            $sub = intval(substr($order->reference, 2)) + 1;
            $ref = 'PO'.$sub;
        }
        $stuts = ['pending', 'being_verified', 'in_preparation', 'in_transit', 'delivered', 'canceled', 'returned', 'reimbursed'];
        $billing_id = Address::inRandomOrder()->first();
        $shipping_id = $this->faker->boolean(75) ? $billing_id : Address::inRandomOrder()->first();

        return [
            'reference' => $ref,
            'total' => 0,
            'subtotal' => 0,
            'tax' => 0,
            'shipping' => rand(1, 10),
            'facture' => null,
            'status' => $stuts[rand(0, count($stuts) - 1)],
            'billing_id' => $billing_id,
            'shipping_id' => $shipping_id,
        ];
    }
}
