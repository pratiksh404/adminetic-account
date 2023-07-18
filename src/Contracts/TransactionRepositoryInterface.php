<?php

namespace Adminetic\Account\Contracts;

use Adminetic\Account\Models\Admin\Transaction;
use Adminetic\Account\Http\Requests\TransactionRequest;

interface TransactionRepositoryInterface
{
    public function indexTransaction();

    public function createTransaction();

    public function storeTransaction(TransactionRequest $request);

    public function showTransaction(Transaction $Transaction);

    public function editTransaction(Transaction $Transaction);

    public function updateTransaction(TransactionRequest $request, Transaction $Transaction);

    public function destroyTransaction(Transaction $Transaction);
}
