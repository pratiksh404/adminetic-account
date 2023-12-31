<?php

namespace Adminetic\Account\Policies;

use Adminetic\Account\Models\Admin\Fiscal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FiscalPolicy
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
        return $user->userCanDo('Fiscal', 'browse');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Fiscal  $fiscal
     * @return mixed
     */
    public function view(User $user, Fiscal $fiscal)
    {
        return $user->userCanDo('Fiscal', 'read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->userCanDo('Fiscal', 'add');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Fiscal  $fiscal
     * @return mixed
     */
    public function update(User $user, Fiscal $fiscal)
    {
        return $user->userCanDo('Fiscal', 'edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Fiscal  $fiscal
     * @return mixed
     */
    public function delete(User $user, Fiscal $fiscal)
    {
        return $user->userCanDo('Fiscal', 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Fiscal  $fiscal
     * @return mixed
     */
    public function restore(User $user, Fiscal $fiscal)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Adminetic\Account\Models\User  $user
     * @param  \Adminetic\Account\Models\Admin\Fiscal  $fiscal
     * @return mixed
     */
    public function forceDelete(User $user, Fiscal $fiscal)
    {
        return true;
    }
}
