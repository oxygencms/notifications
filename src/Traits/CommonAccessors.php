<?php

namespace Oxygencms\Core\Traits;

trait CommonAccessors
{
    /**
     * Get the name of the model.
     *
     * @return string
     */
    public function getModelNameAttribute(): string
    {
        $path = explode('\\', get_called_class());

        return array_pop($path);
    }

    /**
     * Get the url to show a model's instance.
     *
     * @return string
     */
    public function getShowUrlAttribute(): string
    {
        return $this->getUrlFor('show');
    }

    /**
     * Get the url to edit a model's instance.
     *
     * @return string
     */
    public function getEditUrlAttribute(): string
    {
        return $this->getUrlFor('edit');
    }

    /**
     * Get the url to update a model's instance.
     *
     * @return string
     */
    public function getUpdateUrlAttribute(): string
    {
        return $this->getUrlFor('update');
    }

    /**
     * todo: needs refactor
     *
     * @param string $suffix
     * @return bool|string
     */
    protected function getUrlFor(string $suffix): string
    {
        $pieces = preg_split('/(?=[A-Z])/', $this->model_name);

        $model_name = str_slug(implode('-', array_filter($pieces)));

        if (isset($this->route_name_prefixes)) {

            $route_name = implode('.', $this->route_name_prefixes) . ".$model_name.$suffix";

            return route('admin.' . $route_name, $this->getRouteParams());
        }

        // show url
        if ($suffix == 'show') {
            [$prefix, $route_key] = $this->model_name == 'Page'
                ? ['', $this->slug]
                : ['admin.', $this->getRouteKey()];

            return route($prefix . $model_name . ".$suffix", $route_key);
        }

        return route('admin.' . $model_name . ".$suffix", $this->getRouteKey());
    }
}
