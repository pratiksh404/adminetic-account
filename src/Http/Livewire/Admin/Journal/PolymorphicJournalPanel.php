<?php

namespace Adminetic\Account\Http\Livewire\Admin\Journal;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Models\Admin\Ledger;
use Adminetic\Account\Models\Admin\Account;

class PolymorphicJournalPanel extends Component
{
    public $model;
    public $ledger;
    public $journal;

    // Attributes
    public $ledger_account;
    public $journal_id;
    public $account_type;
    public $amount;
    public $particular;
    public $data;

    public $toggle_entry_modal = false;
    public $edit_entry;

    // Resource
    public $accounts;

    protected $listeners = ['initialize_journal_panel' => 'initializeJournalPanel', 'component_refresh' => '$refresh'];

    public function mount($model)
    {
        $this->account_type = CREDIT();
        $this->model = $model;
        $this->journal = $model->initializeJournal();
        $this->accounts = Cache::get('accounts', Account::latest()->get());

        $this->setLedger();
    }

    public function initializeJournalPanel()
    {
        $this->emit('initializeJournalPanel');
    }

    public function updated()
    {
        $this->particular = ('To ' . ($this->ledger_account ?? '')  . ' A/C ..... ' .
            (($this->account_type ?? '') == DEBIT() ? 'Dr.' : (($this->account_type ?? '') == CREDIT() ? 'Cr.' : '')));
    }


    public function print()
    {
        $this->emit('print_journal');
    }

    public function download()
    {
        $this->emit('download_journal');
    }

    public function save()
    {

        $this->validate([
            'ledger_account' => 'required',
            'account_type' => 'required|in:' . DEBIT() . ',' . CREDIT(),
            'amount' => 'required',
            'particular' => 'nullable'
        ]);

        Entry::create([
            'code' => entry_code($this->ledger->id, $this->journal->id),
            'ledger_id' => $this->ledger->id,
            'ledger_account' => $this->ledger_account,
            'journal_id' => $this->journal->id,
            'account_type' => $this->account_type,
            'amount' => $this->amount,
            'data' => $this->data,
            'particular' => $this->particular,
            'issued_by' => Auth::user()->id
        ]);
        $this->journal->refresh();

        $this->toggle_entry_modal = false;
        $this->setAttributeEmpty();

        $this->emit('polymorphic_journal_panel_success', 'New Journal Entry Success');
    }

    public function edit(Entry $entry)
    {
        $this->toggle_entry_modal = true;
        $this->edit_entry = $entry;

        $this->ledger_account = $entry->ledger_account;
        $this->journal_id = $entry->journal_id;
        $this->account_type = $entry->account_type;
        $this->amount = $entry->amount;
        $this->particular = $entry->particular;
        $this->data = $entry->data;
    }

    public function update()
    {
        $this->validate([
            'ledger_account' => 'required',
            'account_type' => 'required|in:' . DEBIT() . ',' . CREDIT(),
            'amount' => 'required',
            'particular' => 'nullable'
        ]);

        if (!is_null($this->edit_entry)) {
            $this->edit_entry->update([
                'ledger_account' => $this->ledger_account,
                'account_type' => $this->account_type,
                'amount' => $this->amount,
                'data' => $this->data,
                'particular' => $this->particular,
                'issued_by' => Auth::user()->id
            ]);

            if (!is_null($this->edit_entry->entryable)) {
                if (method_exists($this->edit_entry->entryable, 'entryAmountAttribute')) {
                    $attribute = $this->edit_entry->entryable->entryAmountAttribute();
                    $this->edit_entry->entryable->update([
                        $attribute => $this->amount
                    ]);
                }
            }
            $this->journal->refresh();

            $this->emit('polymorphic_journal_panel_success', 'Update Journal Entry Success');

            $this->toggle_entry_modal = false;
            $this->setAttributeEmpty();
            $this->edit_entry = null;
        }
    }

    public function delete(Entry $entry)
    {
        if (!is_null($entry->entryable)) {
            $entry->entryable->delete();
        }
        $entry->delete();
        $this->journal->refresh();
    }



    public function render()
    {
        return view('account::livewire.admin.journal.polymorphic-journal-panel');
    }

    private function setLedger()
    {
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
    }

    private function setAttributeEmpty()
    {
        $this->ledger_account = null;
        $this->journal_id = null;
        $this->account_type = null;
        $this->amount = null;
        $this->particular = null;
        $this->data = null;
    }
}
