<?php

namespace Adminetic\Account\Repositories;

use Adminetic\Account\Models\Admin\Account;
use Adminetic\Account\Models\Admin\Transaction;
use Illuminate\Support\Facades\Cache;
use Adminetic\Account\Http\Requests\TransactionRequest;
use Adminetic\Account\Contracts\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    // Transaction Index
    public function indexTransaction()
    {
        $transactions = config('adminetic.caching', true)
            ? (Cache::has('transactions') ? Cache::get('transactions') : Cache::rememberForever('transactions', function () {
                return Transaction::latest()->get();
            }))
            : Transaction::latest()->get();
        return compact('transactions');
    }

    // Transaction Create
    public function createTransaction()
    {
        $accounts = Account::latest()->where('active', 1)->get();
        return compact('accounts');
    }

    // Transaction Store
    public function storeTransaction(TransactionRequest $request)
    {
        Transaction::create($request->validated());
    }

    // Transaction Show
    public function showTransaction(Transaction $transaction)
    {
        return compact('transaction');
    }

    // Transaction Edit
    public function editTransaction(Transaction $transaction)
    {
        $accounts = Account::latest()->where('active', 1)->get();
        return compact('transaction', 'accounts');
    }

    // Transaction Update
    public function updateTransaction(TransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->validated());
    }

    // Transaction Destroy
    public function destroyTransaction(Transaction $transaction)
    {
        $transaction->delete();
    }
}
