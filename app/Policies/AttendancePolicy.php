<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Attendance;
use App\Enums\Permission as PermEnum;

class AttendancePolicy
{
    public function viewAny(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value) || $user->isLeader();
    }

    public function view(Employee $user, Attendance $attendance): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value) || $user->isLeader();
    }

    public function create(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    public function update(Employee $user, Attendance $attendance): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    public function delete(Employee $user, Attendance $attendance): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    public function restore(Employee $user, Attendance $attendance): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    public function forceDelete(Employee $user, Attendance $attendance): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }
}
