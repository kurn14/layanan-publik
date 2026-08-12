<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Invoice;
use App\Enums\Permission as PermEnum;

class InvoicePolicy
{
    public function viewAny(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value) || $user->isLeader();
    }

    public function view(Employee $user, Invoice $invoice): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value) || $user->isLeader();
    }

    public function create(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value);
    }

    public function update(Employee $user, Invoice $invoice): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value);
    }

    public function delete(Employee $user, Invoice $invoice): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value);
    }

    public function restore(Employee $user, Invoice $invoice): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value);
    }

    public function forceDelete(Employee $user, Invoice $invoice): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FINANCE->value);
    }
}
