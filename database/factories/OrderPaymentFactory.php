<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderPayment>
 */
class OrderPaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stuts = ['pending', 'payment.complete', 'payment.failed', 'payment.canceled', 'payment.expired'];
        $channel = ['cm.mtn', 'cm.orange', 'cm.mobile', 'paypal', 'Card'];

        return [
            'reference' => Str::uuid(),
            'status' => $stuts[rand(0, count($stuts) - 1)],
            'channel' => $channel[rand(0, count($channel) - 1)],
            'channel_detail' => null,
            'description' => null,
            'payment_url' => null,
            'error' => null,
            'meta' => null,
            'order_id' => Order::inRandomOrder()->first()->id,
        ];
    }
}
