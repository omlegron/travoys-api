<?php

namespace App\Policies;

use App\User;
use App\PlaceCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlaceCategoryPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the place category listing.
     *
     * @param  \App\User  $user
     * @param  \App\PlaceCategory  $placeCategory
     * @return mixed
     */
    function list(User $user) {
        return true;
    }

    /**
     * Determine whether the user can view the place category.
     *
     * @param  \App\User  $user
     * @param  \App\PlaceCategory  $placeCategory
     * @return mixed
     */
    public function view(User $user, PlaceCategory $placeCategory)
    {
        return true;
    }

    /**
     * Determine whether the user can create place categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the place category.
     *
     * @param  \App\User  $user
     * @param  \App\PlaceCategory  $placeCategory
     * @return mixed
     */
    public function update(User $user, PlaceCategory $placeCategory)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the place category.
     *
     * @param  \App\User  $user
     * @param  \App\PlaceCategory  $placeCategory
     * @return mixed
     */
    public function delete(User $user, PlaceCategory $placeCategory)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the place category.
     *
     * @param  \App\User  $user
     * @param  \App\PlaceCategory  $placeCategory
     * @return mixed
     */
    public function restore(User $user, PlaceCategory $placeCategory)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the place category.
     *
     * @param  \App\User  $user
     * @param  \App\PlaceCategory  $placeCategory
     * @return mixed
     */
    public function forceDelete(User $user, PlaceCategory $placeCategory)
    {
        return false;
    }
}
