<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; // <-- Pastikan ini ada
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Daftarkan Gate baru bernama 'admin'
        Gate::define('admin', function ($user) {
            return $user->peran == 'Admin';
        });
    }
}
