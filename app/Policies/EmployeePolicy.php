<?php

namespace App\Policies;

use App\Models\Employee;
use App\Enums\Permission as PermEnum;

class EmployeePolicy
{
    public function viewAny(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value) || $user->isLeader();
    }

    public function view(Employee $user, Employee $employee): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value) || $user->isLeader();
    }

    public function create(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function update(Employee $user, Employee $employee): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function delete(Employee $user, Employee $employee): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function restore(Employee $user, Employee $employee): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function forceDelete(Employee $user, Employee $employee): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }
}
