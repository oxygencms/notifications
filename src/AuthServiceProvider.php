<?php

namespace Oxygencms\Notifications;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * todo: build from config instead..
     *
     * @var array
     */
    protected $policies = [
        \Oxygencms\Notifications\Models\Notification::class => \Oxygencms\Notifications\Policies\NotificationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
