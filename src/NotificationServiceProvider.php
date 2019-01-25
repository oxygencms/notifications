<?php

namespace Oxygencms\Notifications;

use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'oxygencms');

        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/oxygencms'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../database/seeds/' => database_path('seeds'),
        ], 'seeds');


        if ($this->app->runningInConsole()) {
            $this->commands([
                Oxygencms\Notifications\Commands\CreateNotifications::class, 
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->register(AuthServiceProvider::class);

        $this->mergeConfigFrom(__DIR__.'/../config/oxy_notifications.php', 'oxy_notifications');
    }
}
