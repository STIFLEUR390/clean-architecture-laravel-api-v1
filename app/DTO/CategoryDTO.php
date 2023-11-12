<?php

namespace App\DTO;

use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class CategoryDTO extends Data
{
    #[Computed]
    public string $slug;

    public function __construct(
        public string $name,
        public ?string $img,
        public ?string $description,
    ) {
        $this->slug = Str::slug($this->name);
    }
}
