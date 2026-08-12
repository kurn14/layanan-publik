<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch->locales(['id', 'en', 'ar', 'es']);
        });

        \Illuminate\Support\Facades\Gate::policy(\Spatie\Permission\Models\Role::class, \App\Policies\RolePolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\Spatie\Permission\Models\Permission::class, \App\Policies\PermissionPolicy::class);
    }
}
