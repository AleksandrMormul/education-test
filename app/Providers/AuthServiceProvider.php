<?php

namespace App\Providers;

use App\Models\Ad;
use App\Policies\AdPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Ad::class => AdPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->defineAdmin();
        $this->defineAutoDiscover();
    }

    private function defineAutoDiscover()
    {
        Gate::guessPolicyNamesUsing(function ($class) {
            return str_replace("\\Models\\", "\\Policies\\", $class) . 'Policy';
        });
    }

    private function defineAdmin()
    {
        Gate::before(function ($user) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}
