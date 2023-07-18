<?php

namespace Adminetic\Account\Policies;

use Adminetic\Account\Models\Admin\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
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
        return $user->userCanDo('Transaction', 'browse');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return mixed
     */
    public function view(User $user, Transaction $transaction)
    {
        return $user->userCanDo('Transaction', 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->userCanDo('Transaction', 'add');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return mixed
     */
    public function update(User $user, Transaction $transaction)
    {
        return $user->userCanDo('Transaction', 'edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return mixed
     */
    public function delete(User $user, Transaction $transaction)
    {
        return $user->userCanDo('Transaction', 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return mixed
     */
    public function restore(User $user, Transaction $transaction)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return mixed
     */
    public function forceDelete(User $user, Transaction $transaction)
    {
        return true;
    }
}
