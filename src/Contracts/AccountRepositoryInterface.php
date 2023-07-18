<?php

namespace Adminetic\Account\Contracts;

use Adminetic\Account\Models\Admin\Account;
use Adminetic\Account\Http\Requests\AccountRequest;

interface AccountRepositoryInterface
{
    public function indexAccount();

    public function createAccount();

    public function storeAccount(AccountRequest $request);

    public function showAccount(Account $Account);

    public function editAccount(Account $Account);

    public function updateAccount(AccountRequest $request, Account $Account);

    public function destroyAccount(Account $Account);
}
