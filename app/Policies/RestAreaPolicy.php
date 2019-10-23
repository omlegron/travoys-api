<?php

namespace App\Policies;

use App\User;
use App\RestArea;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestAreaPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin || $user->is_satgas) {
            return true;
        }
    }

    /**
     * Determine whether the user can list the rest area.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    function list(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the rest area.
     *
     * @param  \App\User  $user
     * @param  \App\RestArea  $restArea
     * @return mixed
     */
    public function view(User $user, RestArea $rest_area)
    {
        return true;
    }

    /**
     * Determine whether the user can create rest areas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the rest area.
     *
     * @param  \App\User  $user
     * @param  \App\RestArea  $rest_area
     * @return mixed
     */
    public function update(User $user, RestArea $rest_area)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the rest area.
     *
     * @param  \App\User  $user
     * @param  \App\RestArea  $rest_area
     * @return mixed
     */
    public function delete(User $user, RestArea $rest_area)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the rest area.
     *
     * @param  \App\User  $user
     * @param  \App\RestArea  $rest_area
     * @return mixed
     */
    public function restore(User $user, RestArea $rest_area)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the rest area.
     *
     * @param  \App\User  $user
     * @param  \App\RestArea  $rest_area
     * @return mixed
     */
    public function forceDelete(User $user, RestArea $rest_area)
    {
        return false;
    }
}
