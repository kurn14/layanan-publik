<?php

namespace App\Policies;

use App\Models\Employee;
use Spatie\Permission\Models\Role;
use App\Enums\Permission as PermEnum;

class RolePolicy
{
    public function viewAny(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value) || $user->isLeader();
    }

    public function view(Employee $user, Role $role): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value) || $user->isLeader();
    }

    public function create(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function update(Employee $user, Role $role): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function delete(Employee $user, Role $role): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function restore(Employee $user, Role $role): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }

    public function forceDelete(Employee $user, Role $role): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_USERS->value);
    }
}
