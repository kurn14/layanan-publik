<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Certificate;
use App\Enums\Permission as PermEnum;

class CertificatePolicy
{
    public function viewAny(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value) || $user->isLeader();
    }

    public function view(Employee $user, Certificate $certificate): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value) || $user->isLeader();
    }

    public function create(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    public function update(Employee $user, Certificate $certificate): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    public function delete(Employee $user, Certificate $certificate): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    public function restore(Employee $user, Certificate $certificate): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    public function forceDelete(Employee $user, Certificate $certificate): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }
}
