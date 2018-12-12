<?php

namespace Oxygencms\Notifications;

use Validator;
use Oxygencms\Core\Rules\ClassExists;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Oxygencms\Notifications\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->bindModelName();

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::middleware(['web', 'admin'])
             ->name('admin.')
             ->prefix('admin')
             ->namespace('Oxygencms\Notifications\Controllers')
             ->group(function () {
                Route::resource('notification', 'NotificationController', ['except' => 'show']);
             });
    }

    /**
     * Bind the {model_name} to retrieve a model instance.
     *
     * @return void
     */
    protected function bindModelName(): void
    {
        Route::bind('model_name', function ($model_name) {

            if (in_array($model_name, ['Permission', 'Role'])) {
                $class = 'Oxygencms\\Users\\Models\\' . $model_name;
            } elseif (in_array($model_name, ['Link'])) {
                $class = 'Oxygencms\\Menus\\Models\\' . $model_name;
            } else {
                $class = 'Oxygencms\\' . str_plural($model_name) . '\\Models\\' . $model_name;
            }

            if ( ! class_exists($class)) {
                $class = app()->getNamespace() . "Models\\$model_name";
            }

            Validator::make(['class' => $class], [
                'class' => ['required', 'string', new ClassExists()],
            ])->validate();

            return new $class;
        });
    }
}
