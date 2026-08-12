<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\FacilityBooking;
use App\Enums\Permission as PermEnum;

class FacilityBookingPolicy
{
    public function viewAny(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value) || $user->isLeader();
    }

    public function view(Employee $user, FacilityBooking $facilityBooking): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value) || $user->isLeader();
    }

    public function create(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }

    public function update(Employee $user, FacilityBooking $facilityBooking): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }

    public function delete(Employee $user, FacilityBooking $facilityBooking): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }

    public function restore(Employee $user, FacilityBooking $facilityBooking): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }

    public function forceDelete(Employee $user, FacilityBooking $facilityBooking): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_FACILITIES->value);
    }
}
