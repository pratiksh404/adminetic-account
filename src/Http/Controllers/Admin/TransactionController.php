<?php

namespace Adminetic\Account\Http\Controllers\Admin;

use Adminetic\Account\Models\Admin\Transaction;
use Illuminate\Http\Request;
use Adminetic\Account\Http\Requests\TransactionRequest;
use App\Http\Controllers\Controller;;

use Adminetic\Account\Contracts\TransactionRepositoryInterface;

class TransactionController extends Controller
{
    protected $transactionRepositoryInterface;

    public function __construct(TransactionRepositoryInterface $transactionRepositoryInterface)
    {
        $this->transactionRepositoryInterface = $transactionRepositoryInterface;
        $this->authorizeResource(Transaction::class, 'transaction');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account::admin.transaction.index', $this->transactionRepositoryInterface->indexTransaction());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account::admin.transaction.create', $this->transactionRepositoryInterface->createTransaction());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\TransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $this->transactionRepositoryInterface->storeTransaction($request);
        return redirect(adminRedirectRoute('transaction'))->withSuccess('Transaction Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return view('account::admin.transaction.show', $this->transactionRepositoryInterface->showTransaction($transaction));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        return view('account::admin.transaction.edit', $this->transactionRepositoryInterface->editTransaction($transaction));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Adminetic\Account\Http\Requests\TransactionRequest  $request
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $this->transactionRepositoryInterface->updateTransaction($request, $transaction);
        return redirect(adminRedirectRoute('transaction'))->withInfo('Transaction Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $this->transactionRepositoryInterface->destroyTransaction($transaction);
        return redirect(adminRedirectRoute('transaction'))->withFail('Transaction Deleted Successfully.');
    }
}
