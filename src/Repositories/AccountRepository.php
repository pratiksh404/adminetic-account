<?php

namespace Adminetic\Account\Repositories;

use App\Models\User;
use Adminetic\Account\Models\Admin\Account;
use Adminetic\Account\Http\Requests\AccountRequest;
use Illuminate\Support\Facades\Cache;
use Adminetic\Account\Contracts\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface
{
    // Account Index
    public function indexAccount()
    {
        $accounts = config('adminetic.caching', true)
            ? (Cache::has('accounts') ? Cache::get('accounts') : Cache::rememberForever('accounts', function () {
                return Account::latest()->get();
            }))
            : Account::latest()->get();
        return compact('accounts');
    }

    // Account Create
    public function createAccount()
    {
        $users = Cache::get('users', User::latest()->get());
        return compact('users');
    }

    // Account Store
    public function storeAccount(AccountRequest $request)
    {
        $account = Account::create($request->validated());
        $this->assignUsersToAccount($account);
    }

    // Account Show
    public function showAccount(Account $account)
    {
        return compact('account');
    }

    // Account Edit
    public function editAccount(Account $account)
    {
        $users = Cache::get('users', User::latest()->get());
        return compact('account', 'users');
    }

    // Account Update
    public function updateAccount(AccountRequest $request, Account $account)
    {
        $account->update($request->validated());
        $this->assignUsersToAccount($account);
    }

    // Account Destroy
    public function destroyAccount(Account $account)
    {
        $account->delete();
    }

    // Assign Account To Users
    private function assignUsersToAccount(Account $account)
    {
        if (request()->has('users')) {
            foreach (request()->users as $user_id) {
                $user = User::find($user_id);
                $user->account_id = $account->id;
                $user->save();
            }
        }
    }
}
