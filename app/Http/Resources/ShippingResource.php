<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->whenHas($this->id),
            'name' => $this->whenNotNull($this->name),
            'country' => $this->whenNotNull($this->country),
            'city' => $this->whenNotNull($this->city),
            'line1' => $this->whenNotNull($this->line1),
            'line2' => $this->whenNotNull($this->line2),
            'postal_code' => $this->whenNotNull($this->postal_code),
            'state' => $this->whenNotNull($this->state),
            'personnal' => $this->whenNotNull($this->personnal),
            'civility' => $this->whenNotNull($this->civility),
            'created_at' => $this->whenNotNull(Carbon::parse($this->created_at)),
            'updated_at' => $this->whenNotNull(Carbon::parse($this->updated_at)),
        ];
    }
}
