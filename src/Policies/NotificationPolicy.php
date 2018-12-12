<?php

namespace Oxygencms\Notifications\Policies;

use Oxygencms\Users\Models\User;
use Oxygencms\Core\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function index(User $user)
    {
        if ($user->can('view_notifications') || $user->can('manage_notifications')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create notifications.
     *
     * @param  \Oxygencms\Users\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('create_notification') || $user->can('manage_notifications')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the notification.
     *
     * @param  \Oxygencms\Users\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        if ($user->can('update_notification') || $user->can('manage_notifications')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the notification.
     *
     * @param  \Oxygencms\Users\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        // if ($user->can('delete_notification') || $user->can('manage_notifications')) {
        //     return true;
        // }

        return false;
    }
}
