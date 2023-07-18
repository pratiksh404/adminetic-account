<?php

namespace Adminetic\Account\Contracts;

use Adminetic\Account\Models\Admin\Ledger;
use Adminetic\Account\Http\Requests\LedgerRequest;

interface LedgerRepositoryInterface
{
    public function indexLedger();

    public function createLedger();

    public function storeLedger(LedgerRequest $request);

    public function showLedger(Ledger $Ledger);

    public function editLedger(Ledger $Ledger);

    public function updateLedger(LedgerRequest $request, Ledger $Ledger);

    public function destroyLedger(Ledger $Ledger);
}
