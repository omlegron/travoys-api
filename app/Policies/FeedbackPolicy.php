<?php

namespace App\Policies;

use App\User;
use App\Feedback;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedbackPolicy
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
        return false;
    }

    /**
     * Determine whether the user can view the feedback.
     *
     * @param  \App\User  $user
     * @param  \App\Feedback  $feedback
     * @return mixed
     */
    public function view(User $user, Feedback $feedback)
    {
        return $user->id === $feedback->user_id;
    }

    /**
     * Determine whether the user can create feedback.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the feedback.
     *
     * @param  \App\User  $user
     * @param  \App\Feedback  $feedback
     * @return mixed
     */
    public function update(User $user, Feedback $feedback)
    {
        return $user->id === $feedback->user_id;
    }

    /**
     * Determine whether the user can delete the feedback.
     *
     * @param  \App\User  $user
     * @param  \App\Feedback  $feedback
     * @return mixed
     */
    public function delete(User $user, Feedback $feedback)
    {
        return $user->id === $feedback->user_id;
    }

    /**
     * Determine whether the user can restore the feedback.
     *
     * @param  \App\User  $user
     * @param  \App\Feedback  $feedback
     * @return mixed
     */
    public function restore(User $user, Feedback $feedback)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the feedback.
     *
     * @param  \App\User  $user
     * @param  \App\Feedback  $feedback
     * @return mixed
     */
    public function forceDelete(User $user, Feedback $feedback)
    {
        return false;
    }
}
