<?php

namespace Oxygencms\Core\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ModelController extends Controller
{
    /**
     * Update the active attribute of a model.
     *
     * @param Model   $instance
     * @param         $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateActive(Model $instance, $id, Request $request)
    {
        $this->authorize('update', 'App\\Models\\' . $instance->model_name);

        Validator::make(
            [
                'id' => $id,
                'active' => $active = $request->get('active'),
            ], [
                'id' => "required|integer|exists:{$instance->getTable()},id",
                'active' => 'required|boolean',
            ]
        )->validate();

        $model = $instance::findOrFail($id);

        $model->update(['active' => $active]);

        return jsonNotification("Active status changed.");
    }

    /**
     * Delete a model from database.
     *
     * @param Model $instance
     * @param       $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Model $instance, $id)
    {
        $this->authorize('delete', get_class($instance));

        $instance::findOrFail($id)->delete();

        return jsonNotification('Item successfully deleted.');
    }
}
