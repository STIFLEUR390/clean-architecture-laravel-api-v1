<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPaymentResource extends JsonResource
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
            'status' => $this->whenNotNull($this->status),
            'channel' => $this->whenNotNull($this->channel),
            'channel_detail' => $this->whenNotNull($this->channel_detail),
            'description' => $this->whenNotNull($this->description),
            'payment_url' => $this->whenNotNull($this->payment_url),
            'transaction_id' => $this->whenNotNull($this->transaction_id),
            'meta' => $this->whenNotNull($this->meta),
            'created_at' => $this->whenNotNull(Carbon::parse($this->created_at)),
            'updated_at' => $this->whenNotNull(Carbon::parse($this->updated_at)),
            'error' => $this->whenNotNull($this->error),
            'order_id' => $this->whenNotNull($this->order_id),
            'order' => new OrderResource($this->whenLoaded('order')),
        ];
    }
}
