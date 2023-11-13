<?php

namespace App\Models;

use App\Enums\TransfertStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'currency',
        'amount',
        'reference',
        'transaction_id',
        'channel',
        'channel_detail',
        'beneficiary',
        'description',
        'payment_url',
        'status',
        'error',
    ];

    protected $casts = [
        'status' => TransfertStatus::class,
    ];
}
