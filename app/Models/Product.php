<?php

namespace App\Models;

use App\Enums\ProductStatus;
use App\Enums\ProductStock;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'price',
        'stock',
        'status',
        'date_to_publish',
        'qty',
        'img',
        'category_id',
    ];

    protected $casts = [
        'status' => ProductStatus::class,
        'stock' => ProductStock::class,
    ];

    /**
     * category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
