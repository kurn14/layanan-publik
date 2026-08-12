<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Customer;
use App\Enums\Permission as PermEnum;

class CustomerPolicy
{
    public function viewAny(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value) || $user->isLeader();
    }

    public function view(Employee $user, Customer $customer): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value) || $user->isLeader();
    }

    public function create(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function update(Employee $user, Customer $customer): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function delete(Employee $user, Customer $customer): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function restore(Employee $user, Customer $customer): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function forceDelete(Employee $user, Customer $customer): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }
}
