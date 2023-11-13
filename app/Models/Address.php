<?php

namespace App\Models;

use App\Enums\AddressCivility;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'name', 'country', 'city', 'line1', 'line2', 'postal_code', 'state', 'personnal', 'civility',
    ];

    protected $casts = [
        'civility' => AddressCivility::class,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
