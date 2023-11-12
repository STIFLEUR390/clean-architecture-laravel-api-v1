<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
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
            'currency' => $this->whenNotNull($this->currency),
            'amount' => $this->whenNotNull($this->amount),
            'reference' => $this->whenNotNull($this->reference),
            'transaction_id' => $this->whenNotNull($this->transaction_id),
            'channel' => $this->whenNotNull($this->channel),
            'channel_detail' => $this->whenNotNull($this->channel_detail),
            'beneficiary' => $this->whenNotNull($this->beneficiary),
            'description' => $this->whenNotNull($this->description),
            'payment_url' => $this->whenNotNull($this->payment_url),
            'status' => $this->whenNotNull($this->status),
            'error' => $this->whenNotNull($this->error),
            'created_at' => $this->whenNotNull(Carbon::parse($this->created_at)),
            'updated_at' => $this->whenNotNull(Carbon::parse($this->updated_at)),
        ];
    }
}
