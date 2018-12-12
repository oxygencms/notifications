<?php

namespace Oxygencms\Core\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

trait CommonQueries
{
    /**
     * Appends accessors to all models and relations. Optionally
     * pass relations to be eager loaded as second argument.
     * Not appending accessors? Serialize the results...
     *
     * @param mixed $accessors
     * @param mixed $relations
     * @param bool  $withTrashed
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function allWithAccessors($accessors, $relations = [], bool $withTrashed = false)
    {
        $query = self::with($relations);

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->get()->each(function ($model) use ($accessors, $relations) {

            $model->append($accessors);

            // skip the rest if no relations were passed
            if (empty($relations)) {
                return true;
            }

            // append to related models
            if (is_string($relations)) {
                self::appendAccessors($model, $relations, $accessors);
            } else {
                foreach ($relations as $relation) {
                    self::appendAccessors($model, $relation, $accessors);
                }
            }
        });
    }

    /**
     * todo: revisit - it's questionable!
     * @param $model
     * @param $relations
     * @param $accessors
     *
     * @return mixed
     */
    public static function appendAccessors($model, $relations, $accessors)
    {
        $collection = collect($accessors)->intersect(['show_url', 'create_url', 'edit_url', 'destroy_url']);

        if ($collection->isEmpty()) {
            return $model->{$relations}->each->append($accessors);
        }

        foreach ($collection as $item) {
            $expl = explode('_', $item);

            $suffix = array_pop($expl);

            if (is_null(Route::getRoutes()->getByName("$model->model_name.$suffix"))) {
                unset($accessors[array_search($item, $accessors)]);
            }
        }

        return is_a($model->{$relations}, \Illuminate\Support\Collection::class)
            ? $model->{$relations}->each->append($accessors)
            : $model->{$relations}->append($accessors);
    }

    /**
     * Scope a query to only include active models.
     *
     * @param Builder $query
     *
     * @return Builder $query
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', 1);
    }
}