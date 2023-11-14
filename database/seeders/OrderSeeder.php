<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderPayment;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 13; $i++) {
            $order = Order::factory()->has(
                OrderDetail::factory()->count(rand(1, 5)), 'order_details'
            )->has(
                OrderPayment::factory(), 'order_payment'
            )->create();

            $subtotal = OrderDetail::where('order_id', $order->id)->sum('total');

            $total = $subtotal + $order->shipping;
            Order::whereId($order->id)->update([
                'total' => $total,
                'subtotal' => $subtotal,
            ]);

        }
    }
}
