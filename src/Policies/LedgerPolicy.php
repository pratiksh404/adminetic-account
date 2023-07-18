<?php

namespace Adminetic\Account\Policies;

use Adminetic\Account\Models\Admin\Ledger;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LedgerPolicy
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
        return $user->userCanDo('Ledger', 'browse');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Ledger  $ledger
     * @return mixed
     */
    public function view(User $user, Ledger $ledger)
    {
        return $user->userCanDo('Ledger', 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->userCanDo('Ledger', 'add');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Ledger  $ledger
     * @return mixed
     */
    public function update(User $user, Ledger $ledger)
    {
        return $user->userCanDo('Ledger', 'edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Ledger  $ledger
     * @return mixed
     */
    public function delete(User $user, Ledger $ledger)
    {
        return $user->userCanDo('Ledger', 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Ledger  $ledger
     * @return mixed
     */
    public function restore(User $user, Ledger $ledger)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Ledger  $ledger
     * @return mixed
     */
    public function forceDelete(User $user, Ledger $ledger)
    {
        return true;
    }
}
