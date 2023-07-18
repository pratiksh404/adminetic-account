<?php

namespace Adminetic\Account\Http\Livewire\Admin\Journal;

use Livewire\Component;
use Adminetic\Account\Models\Admin\Fiscal;
use Adminetic\Account\Models\Admin\Ledger;
use Adminetic\Account\Models\Admin\Account;
use Adminetic\Account\Models\Admin\Journal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class JournalPanel extends Component
{
    public $journal;

    // Attributes
    public $journal_id;
    public $fiscal_id;
    public $issued_date;
    public $status;
    public $bill_no;
    public $data;
    public $remark;
    public $approved_by;

    // Resource
    public $fiscals;
    public $ledgers;
    public $accounts;

    protected $listeners = ['initialize_journal_panel' => 'initializeJournalPanel'];

    public function mount($journal = null)
    {
        $this->journal = $journal;
        $this->fiscals = Cache::get('fiscals', Fiscal::latest()->get());
        $this->ledgers = Cache::get('ledgers', Ledger::latest()->get());
        $this->accounts = Cache::get('accounts', Account::latest()->get());

        $this->setAttribute();
    }

    public function updatedFiscalId()
    {
        $this->setBillNo();
    }

    public function add()
    {
        $this->data[] = [
            'ledger_id' => null,
            'ledger_account' => null,
            'account_type' => CREDIT(),
            'amount' => 0,
            'particular' => null
        ];
    }

    public function updatedData()
    {
        if (count($this->data ?? []) > 0) {
            foreach ($this->data as $index => $entry) {
                if (!is_null($entry['ledger_id'])) {
                    $this->data[$index]['code'] = entry_code($entry['ledger_id'], $this->journal_id);
                    $particular = ('To ' . ($entry['ledger_account'] ?? '')  . ' A/C ..... ' .
                        (($entry['account_type'] ?? '') == DEBIT() ? 'Dr.' : (($entry['account_type'] ?? '') == CREDIT() ? 'Cr.' : '')));
                    $this->data[$index]['particular'] =  $particular;
                }
            }
        }
    }

    public function remove($index)
    {
        $data = $this->data;
        unset($data[$index]);
        $this->data = $data;
    }

    public function initializeJournalPanel()
    {
        $this->emit('initializeJournalPanel');
    }

    public function render()
    {
        return view('account::livewire.admin.journal.journal-panel');
    }

    private function setAttribute()
    {
        if (!is_null($this->journal)) {
            $this->journal_id = $this->journal->id;
            $this->fiscal_id = $this->journal->fiscal_id;
            $this->issued_date = $this->journal->issued_date;
            $this->status = $this->journal->status;
            $this->bill_no = $this->journal->bill_no;
            $this->data = $this->journal->data;
            $this->remark = $this->journal->remark;
            $this->approved_by = $this->journal->approved_by;
        } else {
            $this->setBillNo();
            $this->journal_id = ((DB::select("SHOW TABLE STATUS LIKE '" . (config('account.table_prefix', 'account') . '_' . 'journals') . "'"))[0])->Auto_increment;
            $this->fiscal_id = !is_null(active_fiscal()) ? (active_fiscal())->id : null;
        }
    }


    private function setBillNo()
    {
        if (!is_null(active_fiscal())) {
            $fiscal = Fiscal::find($this->fiscal_id);
            $this->bill_no = Journal::where([
                ['fiscal_id', ($fiscal->id ?? active_fiscal())->id ?? null],
            ])->max('id') + 1;
        }
    }
}
