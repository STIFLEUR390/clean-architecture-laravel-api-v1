<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->whenNotNull($this->id),
            'reference' => $this->whenNotNull($this->reference),
            'total' => $this->whenNotNull($this->total),
            'subtotal' => $this->whenNotNull($this->subtotal),
            'tax' => $this->whenNotNull($this->tax),
            'shipping' => $this->whenNotNull($this->shipping),
            'facture' => $this->whenNotNull($this->facture),
            'status' => $this->whenNotNull($this->status),
            'billing_id' => $this->whenNotNull($this->billing_id),
            'shipping_id' => $this->whenNotNull($this->shipping_id),
            'created_at' => $this->whenNotNull(Carbon::parse($this->created_at)),
            'updated_at' => $this->whenNotNull(Carbon::parse($this->updated_at)),
            'order_details' => OrderDetailResource::collection($this->whenLoaded('order_details')),
            'shipping' => new ShippingResource($this->whenLoaded('shipping')),
            'order_payment' => new OrderPaymentResource($this->whenLoaded('order_payment')),
            'billing' => new AddressResource($this->whenLoaded('billing')),
        ];
    }
}
