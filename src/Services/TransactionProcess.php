<?php

namespace Adminetic\Account\Services;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Adminetic\Account\Facades\Account;
use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Models\Admin\Journal;
use Adminetic\Account\Models\Admin\Transaction;
use Adminetic\Account\Models\Admin\Account as Ac;

class TransactionProcess
{
    protected $amount;
    protected $account_id;
    protected $journal_id;
    protected $ledger_id;
    protected $ledger_account;
    protected $account_type;
    protected $entry_morph_model;

    public function __construct($amount, $account_id, $journal_id, $ledger_id, $ledger_account, $account_type, $entry_morph_model = null)
    {
        $this->amount = $amount;
        $this->account_id = $account_id;
        $this->journal_id = $journal_id;
        $this->ledger_id = $ledger_id;
        $this->ledger_account = $ledger_account;
        $this->account_type = $account_type;
        $this->entry_morph_model = $entry_morph_model;
    }


    public function initiate()
    {
        $amount = $this->amount;
        $account_id = $this->account_id;
        $journal_id = $this->journal_id;
        $ledger_id = $this->ledger_id;
        $ledger_account = $this->ledger_account;
        $account_type = $this->account_type;
        $entry_morph_model = $this->entry_morph_model;

        return  DB::transaction(function () use ($amount, $account_id, $journal_id, $ledger_id, $ledger_account, $account_type, $entry_morph_model) {
            $transaction_code = entry_code($ledger_id, $journal_id);
            $particular = ('To ' . ($ledger_account ?? '')  . ' A/C ..... ' .
                (($account_type ?? '') == DEBIT() ? 'Dr.' : (($account_type ?? '') == CREDIT() ? 'Cr.' : '')));

            $entry_data = [
                'code' => $transaction_code,
                'journal_id' => $journal_id,
                'ledger_id' => $ledger_id,
                'ledger_account' => $ledger_account,
                'account_type' => $account_type,
                'amount' => $amount,
                'issued_by' => auth()->check() ? auth()->user()->id : User::first()->id,
                'particular' => $particular
            ];
            $entry = !is_null($this->entry_morph_model) ? $this->entry_morph_model->entry()->create($entry_data) : Entry::create($entry_data);

            $account = Ac::find($account_id);
            /*      $transaction = Transaction::create([
                'code' => $transaction_code,
                'amount' => $amount,
                'particular' => Account::transaction_particular($account_type, $amount, modeDate(Carbon::now()), [
                    'name' => auth()->check() ? auth()->user()->name : User::first()->name,
                    'name' => auth()->check() ? auth()->user()->email : User::first()->email,
                    'phone' => null
                ]),
                'type' => $account_type,
                'issued_by' => auth()->check() ? auth()->user()->id : User::first()->id,
                'issued_by' => Carbon::now(),
                'account_id' => $account_id,
                'entry_id' => $entry->id
            ]); */

            return $entry;
        });
    }

    public function update(Entry $entry)
    {
        $transaction = $entry->transaction;
        $amount = $this->amount;
        $account_id = $this->account_id;
        $journal_id = $this->journal_id;
        $ledger_id = $this->ledger_id;
        $ledger_account = $this->ledger_account;
        $account_type = $this->account_type;
        $entry_morph_model = $this->entry_morph_model;

        return DB::transaction(function () use ($entry, $transaction, $amount, $account_id, $journal_id, $ledger_id, $ledger_account, $account_type, $entry_morph_model) {
            $journal = Journal::find($journal_id);
            $transaction_code = $entry->code;
            $particular = ('To ' . ($ledger_account ?? '')  . ' A/C ..... ' .
                (($account_type ?? '') == DEBIT() ? 'Dr.' : (($account_type ?? '') == CREDIT() ? 'Cr.' : '')));
            $entry->update([
                'code' => $transaction_code,
                'journal_id' => $journal_id,
                'ledger_id' => $ledger_id,
                'ledger_account' => $ledger_account,
                'account_type' => $account_type,
                'amount' => $amount,
                'particular' => $particular
            ]);


            if (!is_null($entry->entryable)) {
                $amount_attribute = $entry->entryable->entryAmountAttribute();
                if (!is_null($entry->entryable->$amount_attribute)) {
                    $entry->entryable()->update([
                        $amount_attribute => $amount
                    ]);
                }
            }

            /*             $account = Ac::find($account_id);
            $transaction->update([
                'code' => $transaction_code,
                'amount' => $amount,
                'particular' => Account::transaction_particular($account_type, $amount, modeDate(Carbon::now()), [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => null
                ]),
                'type' => $account_type,
                'issued_by' => Auth::user()->id,
                'issue_date' => Carbon::now(),
                'account_id' => $account_id,
                'entry_id' => $entry->id
            ]); */

            return $entry;
        });
    }

    public function delete(Entry $entry)
    {
        $transaction = $entry->transaction;
        $entry->delete();
        $transaction->delete();
    }
}
