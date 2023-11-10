<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'meta', 'description',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'customer_id');
    }
}
