<?php

namespace App\Policies;

use App\User;
use App\RestArea;
use App\RestAreaPlace;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestAreaPlacePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view rest area places list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the rest area place.
     *
     * @param  \App\User  $user
     * @param  \App\RestAreaPlace  $restAreaPlace
     * @return mixed
     */
    public function view(User $user, RestAreaPlace $restAreaPlace)
    {
        return true;
    }

    /**
     * Determine whether the user can create rest area places.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSatgas;
    }

    /**
     * Determine whether the user can update the rest area place.
     *
     * @param  \App\User  $user
     * @param  \App\RestAreaPlace  $restAreaPlace
     * @return mixed
     */
    public function update(User $user, RestAreaPlace $restAreaPlace)
    {
        return in_array($restAreaPlace->rest_area_id, $user->satgasAt->pluck('id')->toArray());
    }

    /**
     * Determine whether the user can delete the rest area place.
     *
     * @param  \App\User  $user
     * @param  \App\RestAreaPlace  $restAreaPlace
     * @return mixed
     */
    public function delete(User $user, RestAreaPlace $restAreaPlace)
    {
        return in_array($restAreaPlace->rest_area_id, $user->satgasAt->pluck('id')->toArray());
    }

    /**
     * Determine whether the user can restore the rest area place.
     *
     * @param  \App\User  $user
     * @param  \App\RestAreaPlace  $restAreaPlace
     * @return mixed
     */
    public function restore(User $user, RestAreaPlace $restAreaPlace)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the rest area place.
     *
     * @param  \App\User  $user
     * @param  \App\RestAreaPlace  $restAreaPlace
     * @return mixed
     */
    public function forceDelete(User $user, RestAreaPlace $restAreaPlace)
    {
        return false;
    }
}
