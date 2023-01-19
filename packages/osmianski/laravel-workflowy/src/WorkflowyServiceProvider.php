<?php

namespace Osmianski\Workflowy;

use Illuminate\Support\ServiceProvider;

class WorkflowyServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'osmianski');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'osmianski');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/workflowy.php', 'workflowy');

        // Register the service the package provides.
        $this->app->singleton('workflowy', function ($app) {
            return new Workflowy;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['workflowy'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/workflowy.php' => config_path('workflowy.php'),
        ], 'workflowy.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/osmianski'),
        ], 'workflowy.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/osmianski'),
        ], 'workflowy.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/osmianski'),
        ], 'workflowy.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
