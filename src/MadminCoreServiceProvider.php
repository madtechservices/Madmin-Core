<?php

namespace Madtechservices\MadminCore;

use Madtechservices\MadminCore\app\Console\Commands\SeederCommand;
use Madtechservices\MadminCore\app\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class MadminCoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'madmin-core');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'madmin-core');

        Blade::componentNamespace('Madtechservices\\MadminCore\\app\\View\\Components', 'madmin-core');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config' => config_path(),
            ], 'config');
            $this->publishes([
                __DIR__.'/resources/scss' => resource_path('scss'),
            ], 'scss');
            $this->publishes([
                __DIR__.'/resources/lang' => resource_path('lang/vendor/madmin-core'),
            ], 'lang');

            $this->commands([
                SeederCommand::class,
            ]);
        }

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/config/madmin-core/config.php', 'madmin-core.config');
        $this->mergeConfigFrom(__DIR__.'/config/madmin-core/activitylog.php', 'activitylog');
        $this->mergeConfigFrom(__DIR__.'/config/madmin-core/permission.php', 'permission');
        $this->mergeConfigFrom(__DIR__.'/config/madmin-core/permissionmanager.php', 'permissionmanager');

        // Register the main class to use with the facade
        $this->app->singleton('madmin-core', function () {
            return new MadminCore;
        });

        if(config('madmin-core.config.project_uses_core_error_handling', true) == true)
        {
            $this->app->bind(
                ExceptionHandler::class,
                Handler::class,
            );
        }
    }
}
