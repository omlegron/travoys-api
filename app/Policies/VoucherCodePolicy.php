<?php

namespace App\Policies;

use App\User;
use App\VoucherCode;
use Illuminate\Auth\Access\HandlesAuthorization;

class VoucherCodePolicy
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
        return false;
    }

    /**
     * Determine whether the user can view the voucher code.
     *
     * @param  \App\User  $user
     * @param  \App\VoucherCode  $voucherCode
     * @return mixed
     */
    public function view(User $user, VoucherCode $voucherCode)
    {
        return false;
    }

    /**
     * Determine whether the user can create voucher codes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the voucher code.
     *
     * @param  \App\User  $user
     * @param  \App\VoucherCode  $voucherCode
     * @return mixed
     */
    public function update(User $user, VoucherCode $voucherCode)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the voucher code.
     *
     * @param  \App\User  $user
     * @param  \App\VoucherCode  $voucherCode
     * @return mixed
     */
    public function delete(User $user, VoucherCode $voucherCode)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the voucher code.
     *
     * @param  \App\User  $user
     * @param  \App\VoucherCode  $voucherCode
     * @return mixed
     */
    public function restore(User $user, VoucherCode $voucherCode)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the voucher code.
     *
     * @param  \App\User  $user
     * @param  \App\VoucherCode  $voucherCode
     * @return mixed
     */
    public function forceDelete(User $user, VoucherCode $voucherCode)
    {
        return false;
    }
}
