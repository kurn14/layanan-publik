<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'employees';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'is_active',


    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',

        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->is_active;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isOperator(): bool
    {
        return $this->hasRole('operator');
    }

    public function isLeader(): bool
    {
        return $this->hasRole('leader');
    }

    public function verifiedRegistrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'verified_by');
    }

    public function verifiedPayments(): HasMany
    {
        return $this->hasMany(Payment::class, 'verified_by');
    }
}
