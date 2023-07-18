<?php

namespace Adminetic\Account\Policies;

use Adminetic\Account\Models\Admin\Account;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
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
        return $user->userCanDo('Account', 'browse');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Account  $account
     * @return mixed
     */
    public function view(User $user, Account $account)
    {
        return $user->userCanDo('Account', 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->userCanDo('Account', 'add');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Account  $account
     * @return mixed
     */
    public function update(User $user, Account $account)
    {
        return $user->userCanDo('Account', 'edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Account  $account
     * @return mixed
     */
    public function delete(User $user, Account $account)
    {
        return $user->userCanDo('Account', 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Account  $account
     * @return mixed
     */
    public function restore(User $user, Account $account)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Account  $account
     * @return mixed
     */
    public function forceDelete(User $user, Account $account)
    {
        return true;
    }
}
