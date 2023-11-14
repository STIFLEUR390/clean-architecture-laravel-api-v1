<?php

namespace App\Traits;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use NotchPay\NotchPay;
use NotchPay\Payment;

// use Intervention\Image\Facades\Image;

trait PaymentNotchPay
{
    public function startPayment($order, $items, $channel, $channel_detail, $description = 'Paiement Ecommerce')
    {
        try {
            $step = 0;
            $reference = Str::uuid()->toString();
            NotchPay::setApiKey(env('NOTCH_PAY_PUBLIC_KEY'));
            $billing = $order->billing;
            $user = $user = Customer::whereHas('addresses', function (Builder $query) use ($billing) {
                $query->where('id', $billing->id);
            })->firstOrFail();

            $response = Payment::initialize([
                'email' => $user->email,
                'name' => $user->name,
                'currency' => 'XAF',
                'amount' => $order->total,
                'reference' => $reference,
                'items' => $items,
                'address' => $billing->toArray(),
                'description' => $description,
            ]);
            $transaction_id = $response->transaction->reference;

            if (in_array($channel, ['cm.mobile', 'cm.orange', 'cm.mtn'])) {
                $step = 1;
                Payment::complete($transaction_id, [
                    'channel' => $channel,
                    'data' => [
                        'phone' => $channel_detail['phone'],
                    ],
                ]);
            }

            return [
                'response' => $response,
                'reference' => $reference,
            ];
        } catch (\NotchPay\Exceptions\ApiException $e) {
            if ($step == 1) {
                $this->CancelPayment($transaction_id);
            }
            abort(404, $e->getMessage(), $e->errors);
        }

    }

    public function verifyPayment(string $reference)
    {
        try {
            NotchPay::setApiKey(env('NOTCH_PAY_PUBLIC_KEY'));
            $verifyTransaction = Payment::verify($reference);
            if ($verifyTransaction->transaction->status == '') {
                $status = 'payment.complete';
            }
            switch ($verifyTransaction->transaction->status) {
                case 'complete':
                    $status = 'payment.complete';
                case 'payment.complete':
                    $status = 'payment.complete';
                    break;
                case 'failed':
                    $status = 'payment.failed';
                    break;
                case 'payment.failed':
                    $status = 'payment.failed';
                    break;
                case 'canceled':
                    $status = 'payment.canceled';
                    break;
                case 'payment.canceled':
                    $status = 'payment.canceled';
                    break;
                case 'expired':
                    $status = 'payment.expired';
                    break;
                case 'payment.expired':
                    $status = 'payment.expired';
                    break;
                default:
                    $status = 'pending';
                    break;
            }
            // dd($verifyTransaction, $status);

            return $status;

        } catch (\NotchPay\Exceptions\ApiException $e) {
            // throw new \Exception($e->getMessage(), 404);
            // report($e);
            abort(404, $e->getMessage(), $e->errors);
        }

    }

    public function CancelPayment(string $reference)
    {
        try {
            NotchPay::setApiKey(env('NOTCH_PAY_PUBLIC_KEY'));
            $reponse = Payment::cancel($reference);

            return $reponse->message;

        } catch (\NotchPay\Exceptions\ApiException $e) {
            // throw new \Exception($e->getMessage(), 404);
            // report($e);
            abort(404, $e->getMessage(), $e->errors);
        }

    }

    public function PaymentList()
    {
        try {
            NotchPay::setApiKey(env('NOTCH_PAY_PUBLIC_KEY'));
            /* $params = [
                'perpage' => 10,
                'page' => 1,
            ];
            $verifyTransaction = Payment::list($params); */
            $list = Payment::list();

            return $list->items;

        } catch (\NotchPay\Exceptions\ApiException $e) {
            // throw new \Exception($e->getMessage(), 404);
            // report($e);
            abort(404, $e->getMessage(), $e->errors);
        }

    }
}
