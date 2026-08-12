<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Training;
use App\Enums\Permission as PermEnum;

class TrainingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Employee $user, Training $training): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Employee $user): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Employee $user, Training $training): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Employee $user, Training $training): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Employee $user, Training $training): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }

    /**
     * Determine whether the user can force delete the model.
     */
    public function forceDelete(Employee $user, Training $training): bool
    {
        return $user->hasPermissionTo(PermEnum::MANAGE_TRAININGS->value);
    }
}
