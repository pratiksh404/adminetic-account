<?php

namespace Adminetic\Account\Http\Controllers\Admin;

use Adminetic\Account\Models\Admin\Account;
use Illuminate\Http\Request;
use Adminetic\Account\Http\Requests\AccountRequest;
use App\Http\Controllers\Controller;;

use Adminetic\Account\Contracts\AccountRepositoryInterface;

class AccountController extends Controller
{
    protected $accountRepositoryInterface;

    public function __construct(AccountRepositoryInterface $accountRepositoryInterface)
    {
        $this->accountRepositoryInterface = $accountRepositoryInterface;
        $this->authorizeResource(Account::class, 'account');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account::admin.account.index', $this->accountRepositoryInterface->indexAccount());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account::admin.account.create', $this->accountRepositoryInterface->createAccount());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\AccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountRequest $request)
    {
        $this->accountRepositoryInterface->storeAccount($request);
        return redirect(adminRedirectRoute('account'))->withSuccess('Account Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        return view('account::admin.account.show', $this->accountRepositoryInterface->showAccount($account));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        return view('account::admin.account.edit', $this->accountRepositoryInterface->editAccount($account));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\AccountRequest  $request
     * @param  \Adminetic\Account\Models\Admin\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(AccountRequest $request, Account $account)
    {
        $this->accountRepositoryInterface->updateAccount($request, $account);
        return redirect(adminRedirectRoute('account'))->withInfo('Account Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Adminetic\Account\Models\Admin\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $this->accountRepositoryInterface->destroyAccount($account);
        return redirect(adminRedirectRoute('account'))->withFail('Account Deleted Successfully.');
    }
}
