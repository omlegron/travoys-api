<?php

namespace App\Policies;

use App\User;
use App\Voucher;
use Illuminate\Auth\Access\HandlesAuthorization;

class VoucherPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can list the voucher code.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    function list(User $user) {
        return true;
    }

    /**
     * Determine whether the user can view the voucher.
     *
     * @param  \App\User  $user
     * @param  \App\Voucher  $voucher
     * @return mixed
     */
    public function view(User $user, Voucher $voucher)
    {
        return true;
    }

    /**
     * Determine whether the user can create vouchers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the voucher.
     *
     * @param  \App\User  $user
     * @param  \App\Voucher  $voucher
     * @return mixed
     */
    public function update(User $user, Voucher $voucher)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the voucher.
     *
     * @param  \App\User  $user
     * @param  \App\Voucher  $voucher
     * @return mixed
     */
    public function delete(User $user, Voucher $voucher)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the voucher.
     *
     * @param  \App\User  $user
     * @param  \App\Voucher  $voucher
     * @return mixed
     */
    public function restore(User $user, Voucher $voucher)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the voucher.
     *
     * @param  \App\User  $user
     * @param  \App\Voucher  $voucher
     * @return mixed
     */
    public function forceDelete(User $user, Voucher $voucher)
    {
        return false;
    }
}
