<?php

namespace Adminetic\Account\Repositories;

use Adminetic\Account\Models\Admin\Fiscal;
use Adminetic\Account\Models\Admin\Ledger;
use Adminetic\Account\Http\Requests\LedgerRequest;
use Illuminate\Support\Facades\Cache;
use Adminetic\Account\Contracts\LedgerRepositoryInterface;

class LedgerRepository implements LedgerRepositoryInterface
{
    // Ledger Index
    public function indexLedger()
    {
        $ledgers = config('adminetic.caching', true)
            ? (Cache::has('ledgers') ? Cache::get('ledgers') : Cache::rememberForever('ledgers', function () {
                return Ledger::latest()->get();
            }))
            : Ledger::latest()->get();
        return compact('ledgers');
    }

    // Ledger Create
    public function createLedger()
    {
        return [];
    }

    // Ledger Store
    public function storeLedger(LedgerRequest $request)
    {
        Ledger::create($request->validated());
    }

    // Ledger Show
    public function showLedger(Ledger $ledger)
    {
        return compact('ledger');
    }

    // Ledger Edit
    public function editLedger(Ledger $ledger)
    {
        return compact('ledger');
    }

    // Ledger Update
    public function updateLedger(LedgerRequest $request, Ledger $ledger)
    {
        $ledger->update($request->validated());
    }

    // Ledger Destroy
    public function destroyLedger(Ledger $ledger)
    {
        $ledger->delete();
    }
}
