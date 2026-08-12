<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Payment;
use App\Enums\Permission as PermEnum;

class PaymentPolicy
{
    public function viewAny(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value) || $user->isLeader();
    }

    public function view(Employee $user, Payment $payment): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value) || $user->isLeader();
    }

    public function create(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value);
    }

    public function update(Employee $user, Payment $payment): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value);
    }

    public function delete(Employee $user, Payment $payment): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value);
    }

    public function restore(Employee $user, Payment $payment): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value);
    }

    public function forceDelete(Employee $user, Payment $payment): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value);
    }
}
