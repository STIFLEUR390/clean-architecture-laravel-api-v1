<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->whenNotNull($this->name),
            'slug' => $this->whenNotNull($this->slug),
            'sku' => $this->whenNotNull($this->sku),
            'short_description' => $this->whenNotNull($this->short_description),
            'description' => $this->whenNotNull($this->description),
            'price' => $this->whenNotNull($this->price),
            'stock' => $this->whenNotNull($this->stock),
            'status' => $this->whenNotNull($this->status),
            'date_to_publish' => $this->whenNotNull($this->date_to_publish),
            'qty' => $this->whenNotNull($this->qty),
            'img' => $this->whenNotNull($this->img),
            'created_at' => $this->whenNotNull(Carbon::parse($this->created_at)),
            'updated_at' => $this->whenNotNull(Carbon::parse($this->updated_at)),
            'category_id' => $this->whenNotNull($this->category_id),
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
