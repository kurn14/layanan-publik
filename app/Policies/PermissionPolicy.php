<?php

namespace App\Policies;

use App\Models\Employee;
use Spatie\Permission\Models\Permission;
use App\Enums\Permission as PermEnum;

class PermissionPolicy
{
    public function viewAny(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value) || $user->isLeader();
    }

    public function view(Employee $user, Permission $permission): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value) || $user->isLeader();
    }

    public function create(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function update(Employee $user, Permission $permission): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function delete(Employee $user, Permission $permission): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function restore(Employee $user, Permission $permission): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function forceDelete(Employee $user, Permission $permission): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }
}
