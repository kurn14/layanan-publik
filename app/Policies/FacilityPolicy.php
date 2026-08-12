<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Facility;
use App\Enums\Permission as PermEnum;

class FacilityPolicy
{
    public function viewAny(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value) || $user->isLeader();
    }

    public function view(Employee $user, Facility $facility): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value) || $user->isLeader();
    }

    public function create(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }

    public function update(Employee $user, Facility $facility): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }

    public function delete(Employee $user, Facility $facility): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }

    public function restore(Employee $user, Facility $facility): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }

    public function forceDelete(Employee $user, Facility $facility): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }
}
