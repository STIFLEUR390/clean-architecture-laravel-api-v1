<?php

namespace App\Models;

use App\Enums\PaymentChannel;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPayment extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'status',
        'channel',
        'channel_detail',
        'description',
        'payment_url',
        'error',
        'meta',
        'order_id',
        'transaction_id',
    ];

    protected $casts = [
        'status' => PaymentStatus::class,
        'channel' => PaymentChannel::class,
    ];

    protected function channelDetail(): Attribute
    {
        return Attribute::make(
            // get: fn (?string $value) => json_decode($value),
            set: fn (array $value) => json_encode($value),
        );
    }

    /**
     * order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
