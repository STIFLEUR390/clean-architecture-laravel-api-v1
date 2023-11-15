<?php

namespace App\Policies;

use App\Models\OrderPayment;
use App\Models\User;

class OrderPaymentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return isset($user->id);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OrderPayment $orderPayment): bool
    {
        return isset($user->id) && isset($orderPayment->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return isset($user->id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OrderPayment $orderPayment): bool
    {
        return isset($user->id) && isset($orderPayment->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OrderPayment $orderPayment): bool
    {
        return isset($user->id) && isset($orderPayment->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OrderPayment $orderPayment): bool
    {
        return isset($user->id) && isset($orderPayment->id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OrderPayment $orderPayment): bool
    {
        return isset($user->id) && isset($orderPayment->id);
    }
}
