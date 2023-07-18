<?php

namespace Adminetic\Account\Services;

use Exception;
use Carbon\Carbon;
use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Models\Admin\Ledger;
use Adminetic\Account\Models\Admin\Journal;
use Adminetic\Account\Models\Admin\Account as Ac;
use Adminetic\Account\Services\TransactionProcess;

class JournalEntry
{

    public $model;
    public $journal;
    public $account;
    public $ledger;
    public $amount;
    public $ledger_account;
    public $account_type;
    public $payment;

    public function __construct($model, Ac $account, $amount, $ledger_account, $account_type, $payment = null)
    {
        $this->model = $model;
        $this->account = $account;
        $this->amount = $amount;
        $this->ledger_account = $ledger_account;
        $this->account_type = $account_type;
        $this->payment = $payment;

        if (method_exists($model, 'journal')) {
            $this->journal = $model->journal()->exists() ? $model->journal : $model->journal()->create([
                'fiscal_id' => (active_fiscal())->id,
                'issued_date' => Carbon::now(),
                'bill_no' => Journal::where([
                    ['fiscal_id', (active_fiscal())->id],
                ])->max('id') + 1
            ]);
        } else {
            throw new Exception("Missing function journal. Model not compatible", 1);
        }
        if (method_exists($model, 'ledger_name')) {
            $words = explode(" ", $this->model->ledger_name());
            $acronym = "";

            foreach ($words as $w) {
                $acronym .= mb_substr($w, 0, 1);
            }
            $this->ledger = Ledger::firstOrCreate([
                'name' => $this->model->ledger_name()
            ], [
                'code' => strtoupper($acronym),
                'opening_balance' => 0
            ]);
        } else {
            throw new Exception("Missing function ledger_name. Model not compatible", 1);
        }
    }

    public function add()
    {
        // Performing Transaction
        (new TransactionProcess($this->amount, $this->account->id, $this->journal->id, $this->ledger->id, $this->ledger_account, $this->account_type, $this->payment))->initiate();
        $this->journal->updateDataEntries();
    }
    public function edit(Entry $entry)
    {
        // Updating Transaction
        (new TransactionProcess($this->amount, $this->account->id, $this->journal->id, $this->ledger->id, $this->ledger_account, $this->account_type, $this->payment))->update($entry);
        $this->journal->updateDataEntries();
    }
}
