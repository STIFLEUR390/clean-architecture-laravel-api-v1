<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'reference', 'total', 'subtotal', 'tax', 'shipping', 'facture', 'status', 'billing_id', 'shipping_id',
    ];

    /**
     * order_details
     */
    public function order_details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    /**
     * order_payments
     */
    public function order_payments(): HasMany
    {
        return $this->hasMany(OrderPayment::class, 'order_id');
    }

    /**
     * billing
     */
    public function billing(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'billing_id');
    }

    /**
     * shipping
     */
    public function shipping(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'shipping_id');
    }
}
