<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->whenNotNull($this->id),
            'name' => $this->whenNotNull($this->name),
            'slug' => $this->whenNotNull($this->slug),
            'img' => $this->whenNotNull(parseUrl($this->img)),
            'description' => $this->whenNotNull($this->description),
            'created_at' => $this->whenNotNull(Carbon::parse($this->created_at)),
            'updated_at' => $this->whenNotNull(Carbon::parse($this->updated_at)),
            'posts' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
