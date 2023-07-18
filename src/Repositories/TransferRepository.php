<?php

namespace Adminetic\Account\Repositories;

use Adminetic\Account\Models\Admin\Transfer;
use Illuminate\Support\Facades\Cache;
use Adminetic\Account\Contracts\TransferRepositoryInterface;
use Adminetic\Account\Http\Requests\TransferRequest;

class TransferRepository implements TransferRepositoryInterface
{
    // Transfer Index
    public function indexTransfer()
    {
        $transfers = config('adminetic.caching', true)
            ? (Cache::has('transfers') ? Cache::get('transfers') : Cache::rememberForever('transfers', function () {
                return Transfer::latest()->get();
            }))
            : Transfer::latest()->get();
        return compact('transfers');
    }

    // Transfer Create
    public function createTransfer()
    {
        //
    }

    // Transfer Store
    public function storeTransfer(TransferRequest $request)
    {
        Transfer::create($request->validated());
    }

    // Transfer Show
    public function showTransfer(Transfer $transfer)
    {
        return compact('transfer');
    }

    // Transfer Edit
    public function editTransfer(Transfer $transfer)
    {
        return compact('transfer');
    }

    // Transfer Update
    public function updateTransfer(TransferRequest $request, Transfer $transfer)
    {
        $transfer->update($request->validated());
    }

    // Transfer Destroy
    public function destroyTransfer(Transfer $transfer)
    {
        $transfer->delete();
    }
}
