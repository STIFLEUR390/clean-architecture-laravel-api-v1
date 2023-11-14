<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transfer>
 */
class TransferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stuts = ['transfer.sent', 'transfer.failed', 'transfer.complete'];
        $channel = ['cm.mtn', 'cm.orange', 'cm.mobile', 'paypal', 'Card'];

        return [
            'currency' => 'XAF',
            'amount' => rand(100, 1000),
            'reference' => Str::uuid(),
            'transaction_id' => null,
            'channel' => $channel[rand(0, count($channel) - 1)],
            'channel_detail' => null,
            'beneficiary' => null,
            'description' => null,
            'payment_url' => null,
            'status' => $stuts[rand(0, count($stuts) - 1)],
            'error' => null,
        ];
    }
}
