<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider; // added this so that routesAreCached() can be recognized
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // Was uncommented by default, but I have uncommented it because that is the way it is in the documentation as well as on Andre Madarang's code
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // This is what is in the Laravel 5.6 documentation
        // Passport::routes();

        // This is what is in the Laravel 8 documentation
        // if (! $this->app->routesAreCached()) {
        //     Passport::routes();
        // }

        // This is what Andre Madarang does in the tutorial
        // Since we're only using the password grant option, we can pass in a closure (method) so that the only routes that are generated are only those we need for the password grant
        // This should generate only the routes we need
        Passport::routes(function ($router) {
            $router->forAccessTokens();
        });

        // If your grant_type is password then you should enable implicit grants in your appserviceproviser, something like Passport::enableImplicitGrant();
        Passport::enableImplicitGrant();
    }
}
