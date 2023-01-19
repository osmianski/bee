<?php

namespace Osmianski\Sync;

use Illuminate\Support\ServiceProvider;

class SyncServiceProvider extends ServiceProvider
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
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-sync.php', 'laravel-sync');

        // Register the service the package provides.
//        $this->app->singleton('laravel-sync', function ($app) {
//            return new LaravelSync;
//        });
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
            __DIR__.'/../config/sync.php' => config_path('sync.php'),
        ], 'sync.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/osmianski'),
        ], 'laravel-sync.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/osmianski'),
        ], 'laravel-sync.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/osmianski'),
        ], 'laravel-sync.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
