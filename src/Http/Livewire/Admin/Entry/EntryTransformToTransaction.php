<?php

namespace Adminetic\Account\Http\Livewire\Admin\Entry;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Adminetic\Account\Facades\Account;
use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Models\Admin\Transaction;

class EntryTransformToTransaction extends Component
{
    public $entry;
    public $account;
    public $toggle_entry_transaction_modal = false;

    public function mount(Entry $entry)
    {
        $this->entry = $entry;
        $this->account = $entry->issuedBy->getAccount();
    }
    public function transfer()
    {
        $account = $this->account;
        $entry = $this->entry;

        $transaction = $this->entry->transaction()->create([
            'code' => Str::uuid()->toString(),
            'amount' => $this->entry->amount,
            'particular' => Account::transaction_particular($this->entry->account_type, $this->entry->amount, modeDate(Carbon::now()), [
                'name' => auth()->user()->name,
                'name' => auth()->user()->email,
                'phone' => null
            ]),
            'type' => $this->entry->account_type,
            'issued_by' => auth()->user()->id,
            'issue_date' => Carbon::now(),
            'account_id' => $account->id,
        ]);
        $this->entry->update([
            'transaction_id' => $transaction->id
        ]);

        $this->entry->refresh();
        $this->toggle_entry_transaction_modal = false;
    }
    public function update()
    {
        if (!is_null($this->entry->transaction)) {
            $this->entry->transaction->update([
                'amount' => $this->entry->amount,
                'particular' => Account::transaction_particular($this->entry->account_type, $this->entry->amount, modeDate(Carbon::now()), [
                    'name' => auth()->user()->name,
                    'name' => auth()->user()->email,
                    'phone' => null
                ]),
                'issued_by' => auth()->user()->id,
            ]);
            $this->entry->refresh();
            $this->toggle_entry_transaction_modal = false;
        }
    }
    public function render()
    {
        return view('account::livewire.admin.entry.entry-transform-to-transaction');
    }
}
