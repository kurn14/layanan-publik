<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\FacilityPhoto;
use App\Enums\Permission as PermEnum;

class FacilityPhotoPolicy
{
    public function viewAny(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value) || $user->isLeader();
    }

    public function view(Employee $user, FacilityPhoto $facilityPhoto): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value) || $user->isLeader();
    }

    public function create(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }

    public function update(Employee $user, FacilityPhoto $facilityPhoto): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }

    public function delete(Employee $user, FacilityPhoto $facilityPhoto): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }

    public function restore(Employee $user, FacilityPhoto $facilityPhoto): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }

    public function forceDelete(Employee $user, FacilityPhoto $facilityPhoto): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }
}
