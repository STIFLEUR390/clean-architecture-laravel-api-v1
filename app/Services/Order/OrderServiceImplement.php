<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Repositories\Order\OrderRepositoryImplement;
use App\Traits\PaymentNotchPay;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;
use LaravelEasyRepository\ServiceApi;

class OrderServiceImplement extends ServiceApi implements OrderService
{
    use PaymentNotchPay;

    /**
     * set message api for CRUD
     *
     * @param  string  $title
     * @param  string  $create_message
     * @param  string  $update_message
     * @param  string  $delete_message
     */
    protected $title = '';

    protected $create_message = '';

    protected $update_message = '';

    protected $delete_message = '';

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(OrderRepositoryImplement $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function find($id): Order
    {
        try {
            return $this->mainRepository->find($id);
        } catch (\Exception $exception) {
            Log::error($exception);

            throw $exception;
        }
    }

    public function findOrFail($id): Order
    {
        try {
            if (! is_null(request()->include)) {
                return $this->mainRepository->findOrFailWithRelationship($id, explode(',', request()->include));
            } else {
                return $this->mainRepository->findOrFail($id);
            }
        } catch (\Exception $exception) {
            Log::error($exception);

            throw $exception;
        }
    }

    public function all()
    {
        try {
            return $this->mainRepository->all();
        } catch (\Exception $exception) {
            Log::error($exception);

            throw $exception;
        }
    }

    public function create($data): Order
    {
        DB::beginTransaction();
        try {
            DB::commit();
            // creation de la commande

            $subtotal = 0;
            $shipping = $data['shipping'];

            $products = [];
            $items = [];
            foreach ($data['product'] as $product) {
                $sum = $product['price'] * $product['qty'];
                $subtotal += $sum;
                $products[] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'qty' => $product['qty'],
                    'total' => $sum,
                    'product_id' => $product['product_id'],
                ];
                $prod = Product::findOrFail($product['product_id']);
                $items[] = [
                    'description' => $prod->short_description,
                    'price' => $prod->price,
                    'quantity' => $product['qty'],
                    'image' => $prod->img,
                ];
            }

            $total = $shipping + $subtotal;
            $order = [
                'reference' => generateOrderReference(),
                'total' => $total,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'status' => 'pending',
                'billing_id' => $data['shipping_id'],
                'shipping_id' => $data['billing_id'],
            ];
            $new_data = [
                'order' => $order,
                'products' => $products,
            ];
            $order = $this->mainRepository->create($new_data);
            // Initialisation du paiement

            $order = $this->mainRepository->findOrFailWithRelationship($order->id, ['order_details', 'order_payment', 'billing']);

            $channel = $data['channel'];

            $description = $data['description'] ?? 'Paiement Ecommerce';
            $res = $this->startPayment($order, $items, $channel, $data['channel_detail'], $description);
            $response = $res['response'];
            $payment = [
                'reference' => $res['reference'],
                'status' => $response->transaction->status,
                'channel' => $channel,
                'channel_detail' => $data['channel_detail'],
                'description' => $description,
                'payment_url' => $response->authorization_url,
                'order_id' => $order->id,
                'transaction_id' => $response->transaction->reference,
            ];

            $this->mainRepository->saveOrderPayment($order->id, $payment);

            return $this->mainRepository->findOrFailWithRelationship($order->id, ['order_details', 'order_payment', 'billing']);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }

    public function update($id, array $data): Order
    {
        DB::beginTransaction();
        try {
            DB::commit();

            return $this->mainRepository->update($id, $data);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            DB::commit();

            return $this->mainRepository->delete($id);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }

    public function destroy(array $data)
    {
        DB::beginTransaction();
        try {
            DB::commit();

            return $this->mainRepository->destroy($data);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }

    public function updateOrderStatus(string $id, string $status): bool
    {
        DB::beginTransaction();
        try {
            DB::commit();

            return $this->mainRepository->updateOrderStatus($id, $status);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }

    public function updateOrderPaymentStatus(string $id, string $status): bool
    {
        DB::beginTransaction();
        try {
            DB::commit();

            return $this->mainRepository->updateOrderPaymentStatus($id, $status);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }

    public function getOrderPaymentStatus(string $id)
    {
        DB::beginTransaction();
        try {
            DB::commit();

            return $this->mainRepository->getOrderPaymentStatus($id);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }

    public function GenerateInvoice(string $id): string
    {
        DB::beginTransaction();
        try {
            DB::commit();
            $relations = explode(',', 'order_details,order_payment,billing.customer');

            $order = $this->mainRepository->findOrFailWithRelationship($id, $relations);
            $shipping = $order->shipping;
            $user = $order->billing->customer;
            $billing = $order->billing;
            $products = $order->order_details;
            $payment = $order->order_payment;

            $client = new Party([
                'name' => $billing->name,
                'phone' => $billing->phone ?? '+237690000000',
                'custom_fields' => [
                    'email' => $user->email,
                ],
            ]);

            $customer = new Party([
                'name' => 'Dev Master Shop',
                'address' => 'Douala, Cameroun',
                'phone' => '+237671111111',
                'custom_fields' => [
                    'email' => 'shop@devmaster.cm',
                ],
            ]);

            $notes = [
                'Facture numérique',
                'Remboursmeent non acpeter',
            ];
            $notes = implode('<br>', $notes);

            $items = [];
            foreach ($products as $product) {
                $items[] = (new InvoiceItem())->title($product->name)->pricePerUnit($product->price)->quantity($product->qty);
            }

            $filename = Str::slug($client->name.' '.$customer->name.Carbon::now()->format('YmdHis'));
            Invoice::make('Invoice')
                ->series($order->reference)
                ->status($payment->status->value)
                ->serialNumberFormat('{SERIES}')
                // ->serialNumberFormat('{SEQUENCE}/{SERIES}')
                ->seller($client)
                ->buyer($customer)
                ->date(Carbon::parse($order->created_at))
                ->dateFormat('Y/m/d')
                ->payUntilDays(14)
                ->currencySymbol('FCFA')
                ->currencyCode('XAF')
                ->currencyFormat('{VALUE} {SYMBOL}')
                ->currencyThousandsSeparator('.')
                ->currencyDecimalPoint(',')
                ->filename($filename)
                ->addItems($items)
                ->notes($notes)
                ->logo(public_path('logo/short_logo.png'))
                ->shipping($shipping)
                ->totalDiscount(0)
                ->save('public_uploads_pdf');

            $path = asset('uploads/invoices/'.$filename.'.pdf');

            Order::whereId($id)->update([
                'facture' => $path,
            ]);

            return $path;

        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }

    public function verifyPaiement(string $id): Order
    {
        DB::beginTransaction();
        try {
            DB::commit();
            $order = $this->mainRepository->findOrFailWithRelationship($id, ['order_payment']);
            $res = $this->verifyPayment($order->order_payment->transaction_id);
            OrderPayment::whereId($order->order_payment->id)->update([
                'status' => $res,
            ]);

            return $this->mainRepository->findOrFailWithRelationship($id, ['order_payment']);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }

    public function cancelOrderPayment(string $transaction_id): bool
    {
        DB::beginTransaction();
        try {
            DB::commit();
            $this->verifyPayment($transaction_id);
            Order::where('transaction_id', $transaction_id)->update([
                'status' => 'payment.canceled',
            ]);

            return true;
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);

            throw $exception;
        }
    }
}
