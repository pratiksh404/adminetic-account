<?php

namespace Adminetic\Account\Policies;

use Adminetic\Account\Models\Admin\Transfer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransferPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }


    /**
     * Determine whether the user can view any models.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->userCanDo('Transfer', 'browse');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Transfer  $transfer
     * @return mixed
     */
    public function view(User $user, Transfer $transfer)
    {
        return $user->userCanDo('Transfer', 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->userCanDo('Transfer', 'add');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Transfer  $transfer
     * @return mixed
     */
    public function update(User $user, Transfer $transfer)
    {
        return $user->userCanDo('Transfer', 'edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Transfer  $transfer
     * @return mixed
     */
    public function delete(User $user, Transfer $transfer)
    {
        return $user->userCanDo('Transfer', 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Transfer  $transfer
     * @return mixed
     */
    public function restore(User $user, Transfer $transfer)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Transfer  $transfer
     * @return mixed
     */
    public function forceDelete(User $user, Transfer $transfer)
    {
        return true;
    }
}
