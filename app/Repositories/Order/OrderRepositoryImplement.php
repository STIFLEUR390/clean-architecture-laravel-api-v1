<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderPayment;
use LaravelEasyRepository\Implementations\Eloquent;
use Spatie\ModelInfo\ModelInfo;
use Spatie\QueryBuilder\QueryBuilder;

class OrderRepositoryImplement extends Eloquent implements OrderRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     *
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function find($id): Order
    {
        return $this->model->whereId($id)->first();
    }

    public function findOrFail($id): Order
    {
        return $this->model->whereId($id)->firstOrFail();
    }

    public function all()
    {
        $modelInfo = ModelInfo::forModel(Order::class);
        $attributes = $modelInfo->attributes->pluck('name')->toArray();
        $relations = $modelInfo->relations->pluck('name')->toArray();
        $filters = $sorts = $fields = $attributes;

        $query = QueryBuilder::for(Order::class)
            ->allowedFields($fields)
            ->allowedIncludes($relations)
            ->allowedFilters($filters)
            ->allowedSorts($sorts);

        $per_page = request()->per_page;
        $current_page = request()->page;
        if (! empty($per_page)) {
            $val = $query->paginate($per_page ?? 10, ['*'], 'page', $current_page ?? 1);
        } else {
            $val = $query->get();
        }

        return $val;
    }

    public function create($data): Order
    {
        $order = new order();
        $order->reference = $data['order']['reference'];
        $order->total = $data['order']['total'];
        $order->subtotal = $data['order']['subtotal'];
        $order->shipping = $data['order']['shipping'];
        $order->status = $data['order']['status'];
        $order->billing_id = $data['order']['billing_id'];
        $order->shipping_id = $data['order']['shipping_id'];
        $order->save();

        $products = [];
        foreach ($data['products'] as $product) {
            $products[] = new OrderDetail($product);
        }
        $order->order_details()->saveMany($products);

        $order->refresh();

        return $order;
    }

    public function update($id, array $data): Order
    {
        $order = $this->model->whereId($id)->firstOrFail();
        $order->update($data);

        return $order;
    }

    public function delete($id): bool
    {
        $order = $this->model->whereId($id)->firstOrFail();
        $order->delete();

        return true;
    }

    public function destroy(array $data): bool
    {
        Order::whereIn('id', $data)->delete();

        return true;
    }

    /**
     * Mettre à jour le statut d'une commande
     *
     * @param  mixed  $id
     * @param  mixed  $status
     */
    public function updateOrderStatus(string $id, string $status): bool
    {
        $order = $this->model->whereId($id)->firstOrFail();
        $order->update(['status' => $status]);

        return true;
    }

    /**
     * Mettre à jour le statut du paiement d'une commande
     *
     * @param  mixed  $id
     * @param  mixed  $status
     */
    public function updateOrderPaymentStatus(string $id, string $status): bool
    {
        OrderPayment::whereOrderId($id)->update(['status' => $status]);

        return true;
    }

    /**
     * Récuperer le status du paiement d'une commande
     *
     * @param  mixed  $id
     */
    public function getOrderPaymentStatus(string $id)
    {
        $payment = OrderPayment::whereOrderId($id)->firstOrFail();

        return $payment->status;
    }

    public function findOrFailWithRelationship(string $id, array $relationships): Order
    {
        return $this->model->whereId($id)->with($relationships)->firstOrFail();
    }

    public function saveOrderPayment(string $id, array $data): bool
    {
        $payment = new OrderPayment();
        $payment->order_id = $id;
        if (! empty($data['reference'])) {
            $payment->reference = $data['reference'];
        }
        if (! empty($data['status'])) {
            $payment->status = $data['status'];
        }
        if (! empty($data['channel'])) {
            $payment->channel = $data['channel'];
        }
        if (! empty($data['channel_detail'])) {
            $payment->channel_detail = $data['channel_detail'];
        }
        if (! empty($data['description'])) {
            $payment->description = $data['description'];
        }
        if (! empty($data['payment_url'])) {
            $payment->payment_url = $data['payment_url'];
        }
        if (! empty($data['error'])) {
            $payment->error = $data['error'];
        }
        if (! empty($data['meta'])) {
            $payment->meta = $data['meta'];
        }
        if (! empty($data['transaction_id'])) {
            $payment->transaction_id = $data['transaction_id'];
        }
        $payment->save();

        return true;
    }
}
