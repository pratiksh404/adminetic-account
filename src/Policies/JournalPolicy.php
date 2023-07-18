<?php

namespace Adminetic\Account\Policies;

use Adminetic\Account\Models\Admin\Journal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalPolicy
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
        return $user->userCanDo('Journal', 'browse');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Journal  $journal
     * @return mixed
     */
    public function view(User $user, Journal $journal)
    {
        return $user->userCanDo('Journal', 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->userCanDo('Journal', 'add');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Journal  $journal
     * @return mixed
     */
    public function update(User $user, Journal $journal)
    {
        return $user->userCanDo('Journal', 'edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Journal  $journal
     * @return mixed
     */
    public function delete(User $user, Journal $journal)
    {
        return $user->userCanDo('Journal', 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Journal  $journal
     * @return mixed
     */
    public function restore(User $user, Journal $journal)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Journal  $journal
     * @return mixed
     */
    public function forceDelete(User $user, Journal $journal)
    {
        return true;
    }
}
