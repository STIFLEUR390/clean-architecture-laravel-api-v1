<?php

namespace App\Http\Resources;

use App\Models\OrderDetail;
use App\Models\OrderPayment;
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
            'order_details' => OrderDetail::collection($this->whenLoaded('order_details')),
            'order_payment' => new OrderPayment($this->whenLoaded('order_payment')),
            'billing' => new AddressResource($this->whenLoaded('billing')),
            'shipping' => new AddressResource($this->whenLoaded('shipping')),
        ];
    }
}
