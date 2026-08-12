<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Registration;
use App\Enums\Permission as PermEnum;

class RegistrationPolicy
{
    public function viewAny(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value) || $user->isLeader();
    }

    public function view(Employee $user, Registration $registration): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value) || $user->isLeader();
    }

    public function create(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    public function update(Employee $user, Registration $registration): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    public function delete(Employee $user, Registration $registration): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    public function restore(Employee $user, Registration $registration): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    public function forceDelete(Employee $user, Registration $registration): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }
}
